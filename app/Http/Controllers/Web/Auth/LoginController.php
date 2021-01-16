<?php

namespace App\Http\Controllers\Web\Auth;

use App\Constants;
use App\Models\User\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends BaseLoginController
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
     * @var User
     * */
    protected $anonymousUser;

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
        $this->middleware(Constants::MIDDLEWARE_REDIRECT_IF_IDENTIFIED)->except('logout');
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
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->anonymousUser = $this->setAnonymousUser($request->user());
        return parent::login($request);
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
        User::handleTransferProducts($this->getAnonymousUser(), $user);
        User::handleTransferOrder($this->getAnonymousUser(), $user);
    }

    /**
     * @return User
     */
    public function getAnonymousUser(): User
    {
        return $this->anonymousUser;
    }

    /**
     * @param User $anonymousUser
     */
    public function setAnonymousUser(User $anonymousUser): void
    {
        $this->anonymousUser = $anonymousUser;
    }
}
