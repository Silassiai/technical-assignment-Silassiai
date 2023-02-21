<?php

namespace App\Listeners;

use App\Events\OrderReplySaved;
use App\Services\MailboxOrderService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderReplyNotification
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly MailboxOrderService $mailboxOrderService,
    ) {
    }

    /**
     * Send the reply message to the orderer.
     */
    public function handle(OrderReplySaved $event): void
    {
        $this->mailboxOrderService->replyOrder(
            $event->order,
            $event->orderReplyDto
        );
    }
}
