<?php

namespace Domain\Orders\DTOs;

use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class OrderHistoryItem extends DataTransferObject
{
    public int $orderEventId;

    public ?string $userName;

    public string $operation;

    public string $description;

    public ?Carbon $date;
}
