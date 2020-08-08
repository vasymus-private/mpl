@extends('web.pages.page-layout')

@section('page-content')
    <p><b>Авторизуйтесь, чтобы увидеть свои заказы.</b></p>
    <p>При оформлении заказа Логину присвоено название указанного Вами Email, а пароль сгенерирован автоматитчески и выслан на этот Email.</p>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email">Логин:</label>

            <div>
                <input id="email" type="email" class=" @error('email') has-error @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                <span class="error-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div>
            <label for="password">Пароль:</label>

            <div>
                <input id="password" type="password" class=" @error('password') has-error @enderror" name="password" required autocomplete="current-password">

                @error('password')
                <span class="error-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div>
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

            <label for="remember">
                Запомнить пароль
            </label>
        </div>

        <div>
            <button type="submit">
                Войти
            </button>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    Забыли свой пароль?
                </a>
            @endif
        </div>
    </form>
@endsection
