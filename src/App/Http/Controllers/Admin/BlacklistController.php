<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Admin\BlacklistItemResource;
use App\Http\Resources\Admin\BlacklistResource;
use Domain\Users\Models\Blacklist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Support\H;

class BlacklistController extends BaseAdminController
{
    public function index(Request $request)
    {
        $inertia = H::getAdminInertia();

        $query = Blacklist::query()->select(["*"])->orderByDesc('id')->with('ipDetails');

        if ($request->search) {
            $query->where(function (Builder $q) use ($request) {
                $q->where(sprintf('%s.ip', Blacklist::TABLE), "LIKE", "%{$request->search}%")
                    ->orWhere(sprintf('%s.email', Blacklist::TABLE), "LIKE", "%{$request->search}%");
            });
        }

        return $inertia->render('Blacklist/Index', [
            'blackListItems' => BlacklistItemResource::collection($query->paginate($request->per_page)),
        ]);
    }

    public function create(Request $request)
    {
        $inertia = H::getAdminInertia();

        return $inertia->render('Blacklist/CreateEdit');
    }

    public function edit(Request $request)
    {
        $inertia = H::getAdminInertia();

        /** @var \Domain\Users\Models\Blacklist $blacklist */
        $blacklist = $request->admin_blacklist;

        return $inertia->render('Blacklist/CreateEdit', [
            'blacklist' => (new BlacklistResource($blacklist))->toArray($request),
        ]);
    }
}
