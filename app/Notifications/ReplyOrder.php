<?php

namespace App\Notifications;

use App\DTOs\OrderReplyDto;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReplyOrder extends Notification
{
    use Queueable;

    /**
     * @param OrderReplyDto $orderReplyDto
     */
    public function __construct(
        private readonly OrderReplyDto $orderReplyDto,
    ){
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Send the reply message on the order.
     *
     * @param Order $notifiable
     * @return MailMessage
     */
    public function toMail(Order $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Order has been received')
                    ->line($this->orderReplyDto->replyMessage);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
