<?php

namespace App\Http\Controllers\Web\Auth;

use App\Exceptions\NoSessionUuidException;
use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = "/";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view("web.pages.auth.login");
    }

    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed|User $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $uuid = $request->cookie("session_uuid");

        if ($uuid === null) throw new NoSessionUuidException();

        /** @var User|null $uidUser */
        $uidUser = User::query()->where("session_uuid", $uuid)->first();

        $user->recognizeAnonymous($uuid);


    }
}
