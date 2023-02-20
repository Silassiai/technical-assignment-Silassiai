<?php

namespace App\DTOs;

use Carbon\Carbon;
class OrderReplyDto extends DTO
{
    /** @var Carbon $repliedAt */
    public Carbon $repliedAt;

    /**
     * The reply message on the order.
     *
     * @param string $replyMessage
     */
    public function __construct(
        public readonly string $replyMessage,
    ) {
        /** @var Carbon $this repliedAt */
        $this->repliedAt = now();
    }
}
