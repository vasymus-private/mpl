@extends("admin.layouts.app")

@section("content")
    <form action="{{route("admin.login")}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" />
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" name="password" class="form-control" id="password">
        </div>
        <div class="form-group form-check">
            <input type="checkbox" name="remember" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">Запомнить</label>
        </div>
        <button type="submit" class="btn btn-primary">Войти</button>
    </form>
@endsection
