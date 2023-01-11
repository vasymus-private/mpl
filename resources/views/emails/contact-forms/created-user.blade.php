<?php
/**
 * @var \Domain\Users\Models\ContactForm $contactForm
 */
?>
<x-mail::message>
# Здравствуйте.

Мы получили ваш запрос:

<x-mail::panel>
{{$contactForm->description ?? 'н/а'}}
</x-mail::panel>

Технолог ответит на указанный Email.

Спасибо за использование нашего приложения.

С уважением,<br>
{{ config('app.name') }}
</x-mail::message>
