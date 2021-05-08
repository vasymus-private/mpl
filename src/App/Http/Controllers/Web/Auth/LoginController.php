<?php

namespace App\Http\Controllers\Web\Auth;

use App\Constants;
use Domain\Users\Actions\TransferOrdersAction;
use Domain\Users\Actions\TransferProductsAction;
use Domain\Users\Models\User\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @var int
     * */
    protected $anonymousUserId;

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
        $redirectIfIdentifiedMiddleware = sprintf("%s:%s", Constants::MIDDLEWARE_REDIRECT_IF_IDENTIFIED, implode(',', [Constants::AUTH_GUARD_WEB, Constants::AUTH_GUARD_ADMIN]));
        $this->middleware($redirectIfIdentifiedMiddleware)->except('logout');
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
        $this->setAnonymousUserId($request->user());
        return parent::login($request);
    }

    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed|\Domain\Users\Models\BaseUser\BaseUser $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $anonymousUser = $this->getAnonymousUser();
        /** @var TransferProductsAction $transferProductsAction */
        $transferProductsAction = resolve(TransferProductsAction::class);
        $transferProductsAction->execute($anonymousUser, $user);

        /** @var \Domain\Users\Actions\TransferOrdersAction $transferOrdersAction */
        $transferOrdersAction = resolve(TransferOrdersAction::class);
        $transferOrdersAction->execute($anonymousUser, $user);

        if ($user->is_admin) Auth::guard(Constants::AUTH_GUARD_ADMIN)->login($user, true);

        return redirect()->route('profile');
    }

    /**
     * @return \Domain\Users\Models\User\User
     */
    public function getAnonymousUser(): User
    {
        return User::query()->find($this->anonymousUserId);
    }

    /**
     * @param \Domain\Users\Models\User\User $user
     */
    public function setAnonymousUserId(User $user): void
    {
        $this->anonymousUserId = $user->id;
    }
}
