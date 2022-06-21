<?php

namespace Domain\Common\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self id()
 * @method static self date_creation()
 * @method static self status()
 * @method static self positions()
 * @method static self comment_admin()
 * @method static self importance()
 * @method static self manager()
 * @method static self sum()
 * @method static self name()
 * @method static self phone()
 * @method static self email()
 * @method static self comment_user()
 * @method static self payment_method()
 * @method static self ordering()
 * @method static self active()
 * @method static self unit()
 * @method static self price_purchase()
 * @method static self price_retail()
 * @method static self admin_comment()
 * @method static self availability()
 * @method static self detailed_image()
 * @method static self additional_images()
 * @method static self coefficient()
 * @method static self coefficient_description()
 */
class Column extends Enum
{
    /**
     * @return string[]|int[]
     */
    protected static function values()
    {
        return [
            'id' => 1,
            'name' => 2,
            'date_creation' => 3,
            'status' => 4,
            'positions' => 5,
            'comment_admin' => 6,
            'importance' => 7,
            'manager' => 8,
            'sum' => 9,
            'phone' => 10,
            'email' => 11,
            'comment_user' => 12,
            'payment_method' => 13,
            'unit' => 14,
            'price_purchase' => 15,
            'price_retail' => 16,
            'admin_comment' => 17,
            'availability' => 18,
            'active' => 19,
            'detailed_image' => 20,
            'additional_images' => 21,
            'ordering' => 22,
            'coefficient' => 23,
            'coefficient_description' => 24,
        ];
    }

    /**
     * @return string[]
     */
    protected static function labels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'date_creation' => 'Дата создания',
            'status' => 'Статус',
            'positions' => 'Позиции',
            'comment_admin' => 'Комментарии',
            'importance' => 'Важность',
            'manager' => 'Менеджер',
            'sum' => 'Сумма',
            'phone' => 'Телефон',
            'email' => 'Email',
            'comment_user' => 'Комментарий покупателя',
            'payment_method' => 'Платежная система',
            'unit' => 'Упаковка',
            'price_purchase' => 'Закупочная',
            'price_retail' => 'Розничная',
            'admin_comment' => 'Служебная Информация',
            'availability' => 'Наличие',
            'active' => 'Акт-ть',
            'detailed_image' => 'Детальная картинка',
            'additional_images' => 'Дополнительные фото',
            'ordering' => 'Сорт-ка',
            'coefficient' => 'Коэффициент',
            'coefficient_description' => 'Описание коэффициента',
        ];
    }
}
