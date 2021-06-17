<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

abstract class BaseItemsListComponent extends Component
{
    use WithPagination;
    use HasPagination;

    protected const DEFAULT_PER_PAGE = 20;

    public $total = 0;

    public $last_page;

    public function setPage($page)
    {
        $this->page = $page;
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
        $items = $query->paginate((int)$this->per_page);

        if ($items->lastPage() < $this->page) {
            $this->page = 1;
            $items = $copyQuery->paginate($this->per_page);
        }

        if ($this->request_query) {
            $items->appends($this->request_query);
        }

        $this->total = $items->total();
        $this->last_page = $items->lastPage();

        $this->setItems($items->items());
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
