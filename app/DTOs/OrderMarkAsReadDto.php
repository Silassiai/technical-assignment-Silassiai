<?php

namespace App\DTOs;

use Carbon\Carbon;
class OrderMarkAsReadDto extends DTO
{
    /**
     * Set the seen at when marks as read.
     *
     * @param Carbon $seenAt
     */
    public function __construct(
        public Carbon $seenAt,
    ) {
    }
}
