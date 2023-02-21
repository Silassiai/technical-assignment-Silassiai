<?php

namespace App\Repositories;

use App\DTOs\OrderCreateDto;
use App\DTOs\OrderMarkAsReadDto;
use App\DTOs\OrderReplyDto;
use App\Events\OrderMarkAsReadSaved;
use App\Events\OrderReplySaved;
use App\Exceptions\OrderAlreadyMarkedAsRead;
use App\Exceptions\OrderUpdateFailed;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;

class OrderRepository
{
    /**
     * @param Order $order
     */
    public function __construct(
        protected readonly Order $order,
    ) {
    }

    /**
     * Create the order.
     *
     * @param OrderCreateDto $orderData
     * @return Order
     */
    public function create(OrderCreateDto $orderData): Order
    {
        return Order::firstOrCreate($orderData->toArray());
    }

    /**
     * Return orders paginated.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginated(int $perPage): LengthAwarePaginator
    {
        return $this->order->paginate($perPage);
    }

    /**
     * Marks the order as read.
     *
     * @param Order $order
     * @param OrderMarkAsReadDto $orderMarkAsReadDto
     * @return void
     * @throws Throwable
     */
    public function markAsRead(Order $order, OrderMarkAsReadDto $orderMarkAsReadDto): void
    {
        throw_if(null !== $order->{Order::SEEN_AT}, OrderAlreadyMarkedAsRead::class);

        $order->update($orderMarkAsReadDto->toArray());

        event(new OrderMarkAsReadSaved($order));
    }

    /**
     * Store a reply message.
     *
     * @param Order $order
     * @param OrderReplyDto $orderReplyDto
     * @return void
     */
    public function reply(Order $order, OrderReplyDto $orderReplyDto): void
    {
        $order->update($orderReplyDto->toArray());

        event(new OrderReplySaved($order, $orderReplyDto));
    }
}
