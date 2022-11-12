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

        $paginator = $this->getPaginator($query);

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
