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

class TestMarkupOrderShippedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The view factory implementation.
     *
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $viewFactory;

    /** @var Order */
    protected $order;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->viewFactory = resolve(\Illuminate\Contracts\View\Factory::class);
        $this->order = $order;
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
        $headerLine = "Вы оформили заказ в интернет-магазине union.parket-lux";
        $subcopy = new HtmlString("Если не получается кликнуть на кнопку \"Перейти в личный кабинет\", скопируйте и вставьте УРЛ ниже в ваш веб браузер: <span class=\"break-all\">https://example.com</span>");
        $order = $this->order;

        $data = compact("headerUrl", "headerLine", "subcopy", "order");

        $contents = $this->viewFactory->make("emails.order-shipped", $data)->render();

        $cssInliner = new CssToInlineStyles;
        $css = $this->viewFactory->make("emails.themes.custom", $data)->render();
        $htmlAndCssInline = $cssInliner->convert(
            $contents,
            $css
        );

        return $this
            ->html(new HtmlString($htmlAndCssInline))
            ->subject("market-parket.ru: Ваш заказ номер 9491 от 12.01.2021 обрабатывается")
            ;
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param mixed $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
