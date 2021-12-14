<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

abstract class BaseItemsListComponent extends Component
{
    use WithPagination {
        setPage as protected _setPage;
    }
    use HasPagination;

    protected const DEFAULT_PER_PAGE = 20;

    public $total = 0;

    public $last_page;

    public function setPage($page)
    {
        $this->_setPage($page);
        $this->fetchItems();
    }

    public function handleSearch()
    {
        $this->fetchItems();
    }

    /**
     * @return void
     */
    protected function fetchItems()
    {
        $query = $this->getItemsQuery();

        $copyQuery = clone $query;
        $paginator = $query->paginate((int)$this->per_page);

        if ($paginator->lastPage() < $this->page) {
            $this->page = 1;
            $paginator = $copyQuery->paginate($this->per_page);
        }

        if ($this->request_query) {
            $paginator->appends($this->request_query);
        }

        $this->total = $paginator->total();
        $this->last_page = $paginator->lastPage();

        $this->setItems($paginator->items());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    abstract protected function getItemsQuery(): Builder;

    /**
     * @param \Illuminate\Database\Eloquent\Model[] $items
     *
     * @return void
     */
    abstract protected function setItems(array $items);
}
