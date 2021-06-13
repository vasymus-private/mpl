<?php

namespace Domain\Products\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Products\Models\Char;
use Domain\Products\Models\CharType;
use Illuminate\Support\HtmlString;

class GetCharHtmlAction extends BaseAction
{
    public function execute(Char $char): HtmlString
    {
        $html = '';

        if (!$char->is_empty) {
            if ($char->is_rate) {
                for ($i = 0; $i < CharType::RATE_SIZE; $i++) {
                    if ($char->value > $i) {
                        $html .= '<span class="rate-circle-full"></span>';
                    } else {
                        $html .= '<span class="rate-circle"></span>';
                    }
                }
            } else {
                $html = $char->value;
            }
        }

        $html = sprintf('<div class="dotted_line">%s</div>', $html);

        return new HtmlString($html);
    }
}
