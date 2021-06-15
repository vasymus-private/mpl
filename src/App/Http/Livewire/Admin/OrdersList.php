<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class OrdersList extends Component
{
    public $date = '';

    protected $queryString = [
        'date' => ['except' => ''],
    ];

    public function render()
    {
        return view('admin.livewire.orders-list.orders-list');
    }
}
