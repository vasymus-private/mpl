<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\HtmlString;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class TestMarkupResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The view factory implementation.
     *
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $viewFactory;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->viewFactory = resolve(\Illuminate\Contracts\View\Factory::class);
    }

    /**
     * Build the message.
     *
     * @return $this
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function build()
    {
        $this->viewFactory->flushFinderCache();

        $headerUrl = route('home');
        $headerLine = "Parket Lux";
        $subcopy = new HtmlString("Если не получается кликнуть на кнопку \"Перейти в личный кабинет\", скопируйте и вставьте УРЛ ниже в ваш веб браузер: <span class=\"break-all\">https://example.com</span>");

        $data = compact("headerUrl", "headerLine", "subcopy");

        $contents = $this->viewFactory->make("emails.reset-password", $data)->render();

        $cssInliner = new CssToInlineStyles;
        $css = $this->viewFactory->make("emails.themes.custom", $data)->render();
        $htmlAndCssInline = $cssInliner->convert(
            $contents,
            $css
        );

        return $this
            ->html(new HtmlString($htmlAndCssInline))
            ->subject("Уведомление о Восстановлении Пароля")
            ;
    }
}
