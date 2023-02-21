<?php

namespace App\Listeners;

use App\Adapters\PhpImapMailboxClient;
use App\Events\OrderMarkAsReadSaved;
use App\Models\Order;
use App\Services\MailboxOrderService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MarkMailOrderAsRead
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly MailboxOrderService $mailboxOrderService,
        private readonly PhpImapMailboxClient $phpImapMailboxClient,
    ) {
    }

    /**
     * Mark the order in the mailbox as read.
     */
    public function handle(OrderMarkAsReadSaved $event): void
    {
        $this->mailboxOrderService->markAsSeen(
            $this->phpImapMailboxClient,
            $event->order->{Order::MAIL_ID},
        );
    }
}
