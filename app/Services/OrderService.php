<?php

namespace App\Services;

use App\Adapters\PhpImapMailboxClient;
use App\DTOs\OrderCreateDto;
use App\DTOs\OrderMarkAsReadDto;
use App\DTOs\OrderReplyDto;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;

class OrderService
{
    /**
     * @param OrderRepository $orderRepository
     */
    public function __construct(
        private readonly OrderRepository $orderRepository,
    ) {
    }

    /**
     * Return orders paginated.
     *
     * @param int $perPage
     * @return mixed
     */
    public function getOrders(int $perPage = 10): LengthAwarePaginator
    {
        return $this->orderRepository->getPaginated($perPage);
    }

    /**
     * Create the order.
     *
     * @param OrderCreateDto $orderCreateDto
     * @return void
     */
    public function createOrder(OrderCreateDto $orderCreateDto): void
    {
        $this->orderRepository->create($orderCreateDto);
    }

    /**
     * Marks the order in our database and mail as read.
     *
     * @param Order $order
     * @param Carbon|null $seenAt
     * @return void
     * @throws Throwable
     */
    public function markAsReadOrder(Order $order, Carbon $seenAt = null): void
    {
        $this->orderRepository->markAsRead(
            $order,
            new OrderMarkAsReadDto($seenAt ?? now()),
        );

        resolve(MailboxOrderService::class)->markAsSeen(
            resolve(PhpImapMailboxClient::class),
            $order->{Order::MAIL_ID},
        );
    }

    /**
     * @param Order $order
     * @param OrderReplyDto $orderReplyDto
     * @return void
     */
    public function replyOrder(Order $order, OrderReplyDto $orderReplyDto): void
    {
        $this->orderRepository->reply(
            $order,
            $orderReplyDto
        );

        resolve(MailboxOrderService::class)->replyOrder(
            $order,
            $orderReplyDto
        );
    }
}
