<?php

namespace App\Http\Livewire\Admin;

use Domain\Common\DTOs\OptionDTO;
use Illuminate\Database\Eloquent\Builder;

trait HasPagination
{
    /**
     * @var int|string
     */
    public $per_page;

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO[]}
     */
    public array $per_page_options = [];

    public function mountPerPage()
    {
        $this->per_page = request()->input('per_page', $this->getDefaultPerPage());
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function getPaginator(Builder $query)
    {
        $copyQuery = clone $query;
        $paginator = $query->paginate((int)$this->per_page);

        if ($paginator->lastPage() < $this->page) {
            $this->page = 1;
            $paginator = $copyQuery->paginate($this->per_page);
        }

        if (property_exists($this, 'request_query')) {
            $paginator->appends($this->request_query);
        }

        $this->total = $paginator->total();
        $this->last_page = $paginator->lastPage();

        return $paginator;
    }

    protected function mountPerPageOptions()
    {
        $this->per_page_options = collect(OptionDTO::fromItemsArr([5, 10, 20, 50, 100, 200, 500]))
            ->map(fn(OptionDTO $optionDTO) => $optionDTO->toArray())
            ->all();
    }

    /**
     * @return array[]
     */
    protected function getPerPageQueryString(): array
    {
        return [
            'per_page' => ['except' => $this->getDefaultPerPage()],
        ];
    }

    /**
     * @return string
     */
    protected function getDefaultPerPage(): string
    {
        return defined('static::DEFAULT_PER_PAGE') ? static::DEFAULT_PER_PAGE : 20;
    }
}
