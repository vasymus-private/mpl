<?php

namespace App\Http\Livewire\Admin;

use Carbon\Exceptions\InvalidFormatException;
use Domain\Orders\Models\Order;
use Domain\Products\DTOs\Admin\OrderItemDTO;
use Domain\Users\Models\BaseUser\BaseUser;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class OrdersList extends Component
{
    use WithPagination;
    use HasPagination;
    use HasSelectAll;

    protected const DEFAULT_PER_PAGE = 20;

    protected const DATE_FORMAT_DISPLAY = 'd-m-Y H:i:s';

    protected const DATE_FORMAT_DB_QUERY = 'Y-m-d H:i:s';

    public $date_from = '';

    public $date_to = '';

    public $order_id = '';

    public $email = '';

    public $name = '';

    public $admin_id = '';

    public $total = 0;

    public $last_page;

    public $request_query;

    /**
     * @var array[] @see {@link \Domain\Products\DTOs\Admin\OrderItemDTO}
     */
    public array $items = [];

    protected function queryString(): array
    {
        return array_merge($this->getPerPageQueryString(), [
            'date_from' => ['except' => ''],
            'date_to' => ['except' => ''],
            'order_id' => ['except' => ''],
            'email' => ['except' => ''],
            'name' => ['except' => ''],
            'admin_id' => ['except' => ''],
        ]);
    }

    public function mount()
    {
        $this->mountRequest();
        $this->mountPerPage();
        $this->setItems();
    }

    public function render()
    {
        return view('admin.livewire.orders-list.orders-list', [
            'paginator' => new LengthAwarePaginator(
                $this->items,
                $this->total,
                $this->per_page,
                $this->page
            ),
        ]);
    }

    protected function setItems()
    {
        $query = Order::query()->select(['*']);
        $table = Order::TABLE;
        $usersT = BaseUser::TABLE;

        if ($this->date_from) {
            $query->where("$table.created_at", ">=", Carbon::createFromFormat(static::DATE_FORMAT_DISPLAY, $this->date_from)->format(static::DATE_FORMAT_DB_QUERY));
        }

        if ($this->date_to) {
            $query->where("$table.created_at", "<=", Carbon::createFromFormat(static::DATE_FORMAT_DISPLAY, $this->date_to)->format(static::DATE_FORMAT_DB_QUERY));
        }

        if ($this->email || $this->name) {
            $query->join($usersT, "$table.user_id", "=", "$usersT.id");
            if ($this->email) {
                $query->where("$usersT.email", "LIKE", "%{$this->email}%");
            }
            if ($this->name) {
                $query->where("$usersT.name", "LIKE", "%{$this->name}%");
            }
        }

        if ($this->admin_id) {
            $query->where("$table.admin_id", $this->admin_id);
        }

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

        $this->items = collect($items->items())->map(fn(Order $order) => OrderItemDTO::fromModel($order)->toArray())->all();
    }

    protected function mountRequest()
    {
        $request = request();

        $date_from = $request->input('date_from', '');
        if ($date_from) {
            try {
                $parsed = Carbon::parse($date_from);
                $this->date_from = $parsed->format(static::DATE_FORMAT_DISPLAY);
            } catch (InvalidFormatException $exception) {
                $this->date_from = '';
            }
        }
        $date_to = $request->input('date_to', '');
        if ($date_to) {
            try {
                $parsed = Carbon::parse($date_to);
                $this->date_to = $parsed->format(static::DATE_FORMAT_DISPLAY);
            } catch (InvalidFormatException $exception) {
                $this->date_to = '';
            }
        }

        $this->order_id = $request->input('order_id', '');
        $this->email = $request->input('email', '');
        $this->admin_id = $request->input('admin_id', '');

        $this->request_query = $request->query();
    }
}
