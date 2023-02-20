<?php

namespace App\DTOs;

use Carbon\Carbon;

class OrderCreateDto extends DTO
{
    /**
     * @param string $mailId
     * @param string $subject
     * @param string $body
     * @param Carbon $receivedAt
     * @param Carbon|null $repliedAt
     * @param Carbon|null $seenAt
     */
    public function __construct(
        public readonly string $mailId,
        public readonly string $receivedFrom,
        public readonly string $subject,
        public readonly string $body,
        public readonly Carbon $receivedAt,
        public readonly ?Carbon $seenAt = null,
        public readonly ?Carbon $repliedAt = null,
    ) { }
}
