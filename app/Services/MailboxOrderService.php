<?php

namespace App\Services;

use App\Contracts\EmailClient;
use App\DTOs\OrderCreateDto;
use App\DTOs\OrderReplyDto;
use App\Models\Order;
use App\Notifications\ReplyOrder;
use App\Repositories\OrderRepository;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use PhpImap\Exceptions\ConnectionException;

class MailboxOrderService
{
    /**
     * Import the orders from the mail in our database.
     *
     * @param EmailClient $emailClient
     * @return void
     */
    public function import(EmailClient $emailClient): void
    {

        try {
            $mailIds = $emailClient->mailbox('INBOX')->search();
        } catch (ConnectionException $exception) {
            logger()->error($exception);
            $mailIds = [];
        }

        $orderService = resolve(OrderService::class);

        foreach ($mailIds as $mailId) {
            $message = $emailClient->getById($mailId);

            $orderService->createOrder(
                new OrderCreateDto(
                    $mailId,
                    $message->fromAddress,
                    $message->subject,
                    $message->textPlain,
                    Carbon::parse($message->date),
                    $message->isSeen ? now() : null,
                )
            );
        }
        $emailClient->close();
    }

    /**
     * Marks the mail as read.
     *
     * @param EmailClient $emailClient
     * @param int $mailId
     * @return void
     */
    public function markAsSeen(EmailClient $emailClient, int $mailId): void
    {
        $emailClient->setFlag($mailId, '\\Seen');
    }

    /**
     * Reply to the order.
     *
     * @param Order $order
     * @param OrderReplyDto $orderReplyDto
     * @return void
     */
    public function replyOrder(Order $order, OrderReplyDto $orderReplyDto): void
    {
        $order->notify(new ReplyOrder($orderReplyDto));
    }
}
