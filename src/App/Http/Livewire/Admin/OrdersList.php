<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class OrdersList extends Component
{
    use WithPagination;

    protected const DEFAULT_PER_PAGE = 20;

    public $date = '';

    public $order_id = '';

    public $email = '';

    public $name = '';

    public $manager_id = '';

    public $total = 0;

    public $last_page;

    public $per_page = self::DEFAULT_PER_PAGE;

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO[]}
     */
    public $per_page_options = [];

    /**
     * @var array[] @see {@link \Domain\Products\DTOs\Admin\OrderItemDTO}
     */
    public array $orders = [];

    protected $queryString = [
        'date' => ['except' => ''],
        'order_id' => ['except' => ''],
        'email' => ['except' => ''],
        'name' => ['except' => ''],
        'manager_id' => ['except' => ''],
        'page' => ['except' => 1],
        'per_page' => ['except' => self::DEFAULT_PER_PAGE],
    ];

    public function mount()
    {
        // todo
    }

    public function render()
    {
        return view('admin.livewire.orders-list.orders-list');
    }
}
