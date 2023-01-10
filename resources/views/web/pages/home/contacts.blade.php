@extends('web.pages.page-layout')

@section('page-content')
    <x-h1 :entity="'Производители'"/>
    <x-go-back/>

    <div class="content__white-block">
        <div class="contact-single">
            <p>
                <a href="#point">Пункт самовывоза</a>.&nbsp;Доставляем заказы в регионы России,
                Казахстана и Беларуси.
            </p>
            <p>
                Звоните: <a href="tel:+74957600518">+7 (495) 760-05-18</a>
            </p>
        </div>
        <div class="contact-single">
            <form class="js-contact-form-create" action="{{route('contact-form.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="{{ \Domain\Users\Models\ContactForm::TYPE_CONTACT }}">

                <div class="form-group">
                    <p>Пишите нам на <strong><a href="mailto:market-parket@mail.ru">market-parket@mail.ru</a></strong> или через форму:</p>
                </div>

                <div class="form-group @error('name') is-invalid @enderror">
                    <label>Ваше имя</label>
                    <input class="form-control" type="text" value="{{old('name')}}" name="name" size="60" />

                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group @error('email') is-invalid @enderror">
                    <label>Электронная почта <em>*</em></label>
                    <input class="form-control" type="text" value="{{old('email')}}" name="email" size="60" />

                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group @error('phone') is-invalid @enderror">
                    <label>Телефон</label>
                    <input class="form-control" type="text" name="phone" value="{{old('phone')}}" size="60" />

                    @error('phone')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group @error('description') is-invalid @enderror">
                    <label>Сообщение <em>*</em></label>
                    <textarea class="form-control" name="description">{{old('description')}}</textarea>

                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group @if($errors->has('files') || $errors->has('files.*')) is-invalid @endif">
                    <label>Приложить файл</label>
                    <div class="block-file">
                        <div class="bg_img">
                            <input class="form-control-file" type="file" multiple name="files[]" />
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
                    <label>Введите код с картинки <em>*</em>:</label>
                    <div class="row-line row-line__center">
                        <input class="form-control small" type="text" name="captcha" size="30" maxlength="50" />
                        {!! \Support\H::captchaImage() !!}
                    </div>

                    @error('captcha')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label><em>*</em> - обязательные для заполнения поля</label>
                    <input type="submit" class="btn-submit" />
                    <p class="form-group__text">Нажимая на кнопку "Отправить", я даю <a href="#" data-fancybox="consent-processing-personal-data" data-src="#consent-processing-personal-data">согласие на обработку своих персональных данных</a>
                    </p>
                </div>
            </form>

        </div>
        <div class="contact-single" id="point">
            <p><strong>Пункт выдачи оплаченных заказов:</strong></p>
            <p>Адрес: Москва, Протопоповский переулок, дом 19, строение 13, офис 14</p>
            <p>Время работы: с 10-00 по 18-00, кроме субботы и воскресения.</p>
            <p><img class="map" src="{{asset("images//map.png")}}" alt="" title=""></p>
        </div>
        <div class="contact-single">
            <p><strong>Реквизиты</strong></p>
            <table>
                <tbody>
                <tr>
                    <td>
                        <u>НАЗВАНИЕ ОРГАНИЗАЦИИ</u>:
                    </td>
                    <td>
                        Общество с ограниченной ответственностью «СТП»
                    </td>
                </tr>
                <tr>
                    <td>
                        <u>ИНН / КПП</u>:
                    </td>
                    <td>
                        7716673708 / 771601001
                    </td>
                </tr>
                <tr>
                    <td>
                        <u>ЮРИДИЧЕСКИЙ АДРЕС</u>:
                    </td>
                    <td>
                        129337, г. Москва, ул. Палехская, д. 13-134
                    </td>
                </tr>
                <tr>
                    <td>
                        <u>ФАКТИЧЕСКИЙ АДРЕС</u>:
                    </td>
                    <td>
                        г. Москва, Протоповский переулок, д. 19, стр. 13,&nbsp;офис 14
                    </td>
                </tr>
                <tr>
                    <td>
                        <u>ТЕЛЕФОН</u>:
                    </td>
                    <td>
                        +7 (495) 760-05-18
                    </td>
                </tr>
                <tr>
                    <td>
                        <u>РАСЧЁТНЫЙ СЧЁТ</u>:
                    </td>
                    <td>
                        40702810600280170169&nbsp;в Филиал "Центральный" Банка ВТБ (ПАО)&nbsp;г.
                        Москва<br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <u>БИК</u>:
                    </td>
                    <td>
                        044525411
                    </td>
                </tr>
                <tr>
                    <td>
                        <u>КОРРЕСПОНДЕНТСКИЙ СЧЁТ</u>:
                    </td>
                    <td>
                        30101810145250000411
                    </td>
                </tr>
                <tr>
                    <td>
                        <u>ОГРН</u>:
                    </td>
                    <td>
                        1107746852201
                    </td>
                </tr>
                <tr>
                    <td>
                        <u>ОКПО</u>:
                    </td>
                    <td>
                        68863706
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                    </td>
                    <td>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Реквизиты банка</b>
                    </td>
                    <td>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <u>Название</u>
                    </td>
                    <td>
                        Филиал "Центральный" Банка ВТБ (ПАО)&nbsp;г. Москва<br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <u>БИК</u>
                    </td>
                    <td>
                        044525411
                    </td>
                </tr>
                <tr>
                    <td>
                        <u>Корреспондентский счет</u>:
                    </td>
                    <td>
                        30101810145250000411&nbsp;в Отделении 1 Главного управления Центрального
                        банка Российской Федерации по Центральному федеральному округу г. Москва
                    </td>
                </tr>
                <tr>
                    <td>
                        <u>Адрес</u>:
                    </td>
                    <td>
                        103055, г. Москва, ул. Тихвинская, д. 9, стр. 1
                    </td>
                </tr>
                <tr>
                    <td>
                        <u>Телефон</u>
                    </td>
                    <td>
                        +7(499) 972-66-00
                    </td>
                </tr>
                <tr>
                    <td>
                        <u>ИНН</u>
                    </td>
                    <td>
                        7702070139
                    </td>
                </tr>
                <tr>
                    <td>
                        <u>ОКПО</u>
                    </td>
                    <td>
                        29292940
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                    </td>
                    <td>
                        <br>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
