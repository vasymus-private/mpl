<?php

namespace App\Http\Livewire\Admin;

use Domain\Common\DTOs\OptionDTO;

trait HasPagination
{
    public $per_page;

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO[]}
     */
    public $per_page_options = [];

    public function mountPerPage()
    {
        $this->per_page_options = collect(OptionDTO::fromItemsArr([5, 10, 20, 50, 100, 200, 500]))
            ->map(fn(OptionDTO $optionDTO) => $optionDTO->toArray())
            ->all();
        $this->per_page = request()->input('per_page', $this->getDefaultPerPage());
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
