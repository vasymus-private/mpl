<?php

namespace App\Http\Livewire\Admin;

use Domain\Products\Models\Category;
use Livewire\Component;

class SearchForm extends Component
{
    public string $currentRoute;

    public string $newRoute;

    public $category_id = null;

    public $category_name = null;

    public $search = '';

    public $page = 1;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
        'category_id' => ['except' => null],
    ];

    /**
     * @param \Domain\Products\Models\Category|null $category
     */
    public function mount($category = null)
    {
        if ($category) {
            $this->category_id = $category->id;
            $this->category_name = $category->name;
        }
    }

    public function clearAll()
    {
        return redirect()->route($this->currentRoute);
    }

    public function clearPrepend()
    {
        $this->category_id = null;
        return redirect()->route($this->currentRoute, $this->getRouteParams());
    }

    public function submit()
    {
        return redirect()->route($this->currentRoute, $this->getRouteParams());
    }

    public function newItem()
    {
        return redirect()->route($this->newRoute);
    }

    public function render()
    {
        return view('admin.livewire.search-form');
    }

    protected function getRouteParams(): array
    {
        $routeParams = [
            'search' => $this->search,
            'page' => $this->page,
        ];
        if ($this->category_id) {
            $routeParams['category_id'] = $this->category_id;
        }

        return $routeParams;
    }
}
