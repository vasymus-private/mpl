<?php

namespace Support\CBRcurrencyConverter;

use Spatie\DataTransferObject\DataTransferObject;

class RateItemDTO extends DataTransferObject
{
    /**
     * @var int
     */
    public int $NumCode;

    /**
     * @var string
     */
    public string $CharCode;

    /**
     * @var int
     */
    public int $Nominal;

    /**
     * @var string
     */
    public string $Name;

    /**
     * @var string
     */
    public string $ValueRaw;

    /**
     * @var float
     */
    public float $Value;
}
