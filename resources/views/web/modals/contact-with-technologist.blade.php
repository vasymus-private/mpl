<div id="contact-with-technologist" class="modal-call-us">
    <div class="popup-container">
        <form class="form-horizontal js-contact-form-create" action="{{route('contact-form.store')}}" method="POST"
              enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="{{ \Domain\Users\Models\ContactForm::TYPE_REQUEST_TECHNOLOGIST }}">
            <p>Консультация по телефону:<br><a href="tel:+74953638799">+7(495) 363-87-99</a></p>
            <h4>Связаться с технологом</h4>
            <div class="form-group @if($errors->has('name') && (int)old('type') === \Domain\Users\Models\ContactForm::TYPE_REQUEST_TECHNOLOGIST) is-invalid @endif">
                <input placeholder="Ваше имя" type="text" class="form-control" name="name" value="{{(int)old('type') === \Domain\Users\Models\ContactForm::TYPE_REQUEST_TECHNOLOGIST ? old('name') : ''}}">

                @if((int)old('type') === \Domain\Users\Models\ContactForm::TYPE_REQUEST_TECHNOLOGIST)
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                @endif
            </div>
            <div class="form-group @if($errors->has('email') && (int)old('type') === \Domain\Users\Models\ContactForm::TYPE_REQUEST_TECHNOLOGIST) is-invalid @endif">
                <input placeholder="Электронная почта" type="text" class="form-control" name="email" value="{{(int)old('type') === \Domain\Users\Models\ContactForm::TYPE_REQUEST_TECHNOLOGIST ? old('email') : ''}}">

                @if((int)old('type') === \Domain\Users\Models\ContactForm::TYPE_REQUEST_TECHNOLOGIST)
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                @endif
            </div>
            <div class="form-group @if($errors->has('description') && (int)old('type') === \Domain\Users\Models\ContactForm::TYPE_REQUEST_TECHNOLOGIST) is-invalid @endif">
                <textarea placeholder="Ваш вопрос" name="description" cols="40" rows="5" class="form-control textarea-question">{{(int)old('type') === \Domain\Users\Models\ContactForm::TYPE_REQUEST_TECHNOLOGIST ? old('description') : ''}}</textarea>

                @if((int)old('type') === \Domain\Users\Models\ContactForm::TYPE_REQUEST_TECHNOLOGIST)
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                @endif
            </div>
            <div class="form-group @if($errors->has('phone') && (int)old('type') === \Domain\Users\Models\ContactForm::TYPE_REQUEST_TECHNOLOGIST) is-invalid @endif">
                <input placeholder="Телефон" type="text" class="form-control" name="phone" value="{{old('phone')}}">

                @if((int)old('type') === \Domain\Users\Models\ContactForm::TYPE_REQUEST_TECHNOLOGIST)
                    @error('phone')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                @endif
            </div>
            <div class="form-group @if($errors->has('captcha') && (int)old('type') === \Domain\Users\Models\ContactForm::TYPE_REQUEST_TECHNOLOGIST) is-invalid @endif">
                <div class="col-sm-12 col-xs-12">
                    <div>Введите код с картинки <em>*</em>:</div>
                    <div class="js-captcha-wrapper">
                        {!! \Support\H::captchaImage() !!}
                    </div>
                    <input type="text" name="captcha" class="form-control">
                </div>
                @if((int)old('type') === \Domain\Users\Models\ContactForm::TYPE_REQUEST_TECHNOLOGIST)
                    @error('captcha')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                @endif
            </div>

            @error('blacklist')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <button type="submit" class="pull-right btn-blue fixsize">Отправить</button>
            </div>
        </form>
    </div>
</div>
