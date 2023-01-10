@extends('web.pages.page-layout')

@section('page-content')
    <div class="content-header">
        <div class="content-header__line">
            <h1 class="content-header__title">
                <span>Добавить вопрос</span>
            </h1>
        </div>
    </div>

    <div class="row-line row-line__right">
        <div class="column-back">
            <a href="#" title="вернуться на предыдущую страницу" class="btn-back js-back">
                <img src="{{asset("images/general/backarow.svg")}}" width="97" alt="">
            </a>
        </div>
    </div>
    <div class="content__white-block">
        <form class="form-horizontal js-contact-form-create"  action="{{route('contact-form.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="{{ \Domain\Users\Models\ContactForm::TYPE_QUESTION }}">

            <div class="form-group @error('description') is-invalid @enderror">
                <label for="form-ask-question">Ваш вопрос *:</label>
                <textarea id="form-ask-question" name="description" cols="40" rows="5" class="form-control textarea-question">{{old('description')}}</textarea>

                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group @error('name') is-invalid @enderror">
                <label for="form-ask-name">Ваше имя</label>
                <input id="form-ask-name" type="text" class="form-control" name="name" value="{{old('name')}}" />

                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group @error('email') is-invalid @enderror">
                <label for="form-ask-email">Электронная почта *:</label>
                <input id="form-ask-email" type="text" class="form-control" name="email" value="{{old('email')}}" />

                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group @if($errors->has('files') || $errors->has('files.*')) is-invalid @endif">
                <label for="form-ask-files">Файлы</label>
                <div class="block-file">
                    <div class="bg_img">
                        <input class="form-control-file" id="form-ask-files" type="file" multiple name="files[]" />
                    </div>
                </div>

                @error('files')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                @foreach($errors->get('files.*') as $errorMessages)
                    @foreach($errorMessages as $errorMessage)
                        <div class="alert alert-danger">{{ $errorMessage }}</div>
                    @endforeach
                @endforeach
            </div>

            <div class="form-group @error('captcha') is-invalid @enderror">
                <div class="col-sm-12 col-xs-12">
                    <div>Введите код с картинки <em>*</em>:</div>
                    <div class="row-line row-line__center">
                        <input type="text" name="captcha" size="30" maxlength="50" class="form-control small">
                        {!! \Support\H::captchaImage() !!}
                    </div>
                </div>

                @error('captcha')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            @error('blacklist')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <label><em>*</em> - обязательные для заполнения поля</label>
                <input type="submit" value="Отправить вопрос" class="btn-submit" />
                <p class="form-group__text">Нажимая на кнопку "Отправить вопрос", я даю <a href="#" data-fancybox="consent-processing-personal-data" data-src="#consent-processing-personal-data">согласие на обработку своих персональных данных</a></p>
            </div>
        </form>
        <div class="form-group__item">
            <p><a href="{{route(\App\Constants::ROUTE_WEB_FAQ_INDEX)}}">Перейти в список вопросов</a></p>
        </div>
    </div>
@endsection
