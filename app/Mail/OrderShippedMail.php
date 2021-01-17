<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\HtmlString;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class OrderShippedMail extends Mailable
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

    /** @var int */
    protected $anonymousId;

    /** @var int */
    protected $identifiedId;

    /** @var string|null */
    protected $password;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     * @param int $anonymousId
     * @param int|null $identifiedId
     * @param string|null $password
     *
     * @return void
     */
    public function __construct(Order $order, int $anonymousId, int $identifiedId = null, string $password = null)
    {
        $this->viewFactory = resolve(\Illuminate\Contracts\View\Factory::class);
        $this->order = $order;
        $this->anonymousId = $anonymousId;
        $this->identifiedId = $identifiedId;
        $this->password = $password;
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

        $actionUrl = $this->verificationUrl();

        $headerUrl = route('home');
        $headerLine = "Вы оформили заказ в интернет-магазине union.parket-lux";
        $subcopy = new HtmlString('Если не получается кликнуть на кнопку "Перейти в личный кабинет", скопируйте и вставьте УРЛ ниже в ваш веб браузер: <span class="break-all">' . $actionUrl . '</span>');
        $order = $this->order;
        $password = $this->password;

        $data = compact("headerUrl", "headerLine", "subcopy", "order", "password");

        $contents = $this->viewFactory->make("emails.order-shipped", $data)->render();

        $cssInliner = new CssToInlineStyles;
        $css = $this->viewFactory->make("emails.themes.custom", $data)->render();
        $htmlAndCssInline = $cssInliner->convert(
            $contents,
            $css
        );

        return $this
                ->html(new HtmlString($htmlAndCssInline))
                ->subject("union.parket-lux: Ваш заказ номер 9491 от 12.01.2021 обрабатывается")
            ;
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param mixed $notifiable
     * @return string
     */
    protected function verificationUrl()
    {
        return URL::signedRoute(
            'profile.identify',
            [
                'anonymous' => $this->anonymousId,
                'identified' => $this->identifiedId,
                //'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
