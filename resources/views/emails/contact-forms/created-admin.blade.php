<?php
/**
 * @var \Domain\Users\Models\ContactForm $contactForm
 */
?>
<x-mail::message>
# Здравствуйте.

Контактная форма `{{$contactForm->type_name}}` была отправлена.

@if($contactForm->ipDetails)
Ip: `{{ $contactForm->ip }}`; страна: `{{$contactForm->ipDetails->country_name ?? 'н/а'}}` <img style="max-width: 40px;" src="{{$contactForm->ipDetails->country_img}}" alt="" /> город: `{{$contactForm->ipDetails->city ?? 'н/а'}}`.
@endif

Email: {{$contactForm->email ?? 'н/а'}}

Имя: {{$contactForm->name ?? 'н/а'}}

Телефон: {{$contactForm->phone ?? 'н/а'}}

<x-mail::panel>
Сообщение: {{$contactForm->description ?? 'н/а'}}
</x-mail::panel>

Просмотреть в <a target="_blank" href="{{route(\App\Constants::ROUTE_ADMIN_CONTACT_FORMS_SHOW, ['admin_contact_form', $contactForm->id])}}">админ-панели</a>.

Спасибо,<br>
{{ config('app.name') }}
</x-mail::message>
