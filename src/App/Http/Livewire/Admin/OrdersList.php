<?php

namespace App\Http\Livewire\Admin;

use Carbon\Exceptions\InvalidFormatException;
use Domain\Common\DTOs\OptionDTO;
use Domain\Orders\Models\Order;
use Domain\Products\DTOs\Admin\OrderItemDTO;
use Domain\Users\Models\Admin;
use Domain\Users\Models\BaseUser\BaseUser;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;

class OrdersList extends BaseItemsListComponent
{
    use HasSelectAll;
    use HasManagers;

    protected const DATE_FORMAT_DISPLAY = 'd-m-Y H:i:s';

    protected const DATE_FORMAT_DB_QUERY = 'Y-m-d H:i:s';

    public $date_from = '';

    public $date_to = '';

    public $order_id = '';

    public $email = '';

    public $name = '';

    public $admin_id = '';

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
        $this->fetchItems();
        $this->initManagersOptions();
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

    public function clearFilters()
    {
        $this->date_from = '';
        $this->date_to = '';
        $this->order_id = '';
        $this->email = '';
        $this->name = '';
        $this->admin_id = '';
        $this->fetchItems();
    }

    /**
     * @inheritDoc
     */
    protected function getItemsQuery(): Builder
    {
        $query = Order::query()->select(['*'])->with(['user', 'admin', 'status', 'products', 'payment', 'importance']);
        $table = Order::TABLE;
        $usersT = BaseUser::TABLE;

        if ($this->date_from) {
            try {
                $parsed = Carbon::parse($this->date_from);
            } catch (InvalidFormatException $exception) {
                $parsed = null;
            }
            if ($parsed) {
                $query->where("$table.created_at", ">=", $parsed->format(static::DATE_FORMAT_DB_QUERY));
            }
        }

        if ($this->date_to) {
            try {
                $parsed = Carbon::parse($this->date_to);
            } catch (InvalidFormatException $exception) {
                $parsed = null;
            }
            if ($parsed) {
                $query->where("$table.created_at", "<=", $parsed->format(static::DATE_FORMAT_DB_QUERY));
            }
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

        if ($this->order_id) {
            $query->where("$table.id", $this->order_id);
        }

        $query->orderBy("$table.id", 'desc');

        return $query;
    }

    /**
     * @inheritDoc
     */
    protected function setItems(array $items)
    {
        $this->items = collect($items)->map(fn(Order $order) => OrderItemDTO::fromModel($order)->toArray())->all();
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
