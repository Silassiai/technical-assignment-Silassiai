<?php

namespace App\Events;

use App\DTOs\OrderReplyDto;
use App\Models\Order;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderReplySaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance when the replied_at has been saved.
     */
    public function __construct(
        public readonly Order $order,
        public readonly OrderReplyDto $orderReplyDto
    ) {
    }
}
