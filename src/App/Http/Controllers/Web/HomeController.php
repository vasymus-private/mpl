<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Providers\AuthServiceProvider;
use Domain\Orders\Models\Order;
use Domain\Services\Models\Service;
use Domain\Users\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('web.pages.home.home');
    }

    public function media(Request $request)
    {
        /** @var \Spatie\MediaLibrary\MediaCollections\Models\Media $media */
        $media = Media::query()->findOrFail($request->id);

        $model = $media->model()->firstOrFail();

        switch (true) {
            case $model instanceof Order : {
                /** @var \Domain\Users\Models\User\User $user */
                $user = $model->user;
                if (!$user) abort(404);

                $this->authorize(AuthServiceProvider::MEDIA_SHOW, $user);

                return $media->toResponse($request);
            }
        }

        abort(404);

        return view('test');
    }

    public function howto(Request $request)
    {
        return view("web.pages.home.howto");
    }

    public function delivery(Request $request)
    {
        return view("web.pages.home.delivery");
    }

    public function purchaseReturn(Request $request)
    {
        return view("web.pages.home.return");
    }

    public function contacts(Request $request)
    {
        return view("web.pages.home.contacts");
    }

    public function ask(Request $request)
    {
        return view("web.pages.home.ask");
    }

    public function viewed(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $products = $user->viewed()->orderBy("pivot_created_at", "desc")->paginate(
            $request->input("per_page")
        );

        return view("web.pages.home.viewed", compact("products"));
    }

    public function aside(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $products = $user->aside()->orderBy("pivot_created_at", "desc")->get();

        return view('web.pages.home.aside', compact("products"));
    }
}
