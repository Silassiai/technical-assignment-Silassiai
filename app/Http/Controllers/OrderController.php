<?php

namespace App\Http\Controllers;

use App\DTOs\OrderReplyDto;
use App\Http\Requests\OrderReplyRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class OrderController extends Controller
{
    /**
     * @param OrderService $orderService
     */
    public function __construct(
        private readonly OrderService $orderService,
    ) {
    }

    /**
     * Display a listing of the orders.
     */
    public function index(): Response
    {
        return Inertia::render('Order/Index', [
            'orders' => OrderResource::collection($this->orderService->getOrders()),
        ]);
    }

    /**
     * Mark the order as read.
     *
     * @param Order $order
     * @return mixed
     * @throws Throwable
     */
    public function read(Order $order): JsonResponse
    {
        $this->orderService->markAsReadOrder($order);

        return response()->json();
    }

    /**
     * Reply to the order.
     *
     * @param OrderReplyRequest $replyOrderRequest
     * @param Order $order
     * @return JsonResponse
     */
    public function reply(OrderReplyRequest $replyOrderRequest, Order $order): JsonResponse
    {
        $this->orderService->replyOrder(
            $order,
            OrderReplyDto::fromRequest($replyOrderRequest)
        );

        return response()->json();
    }
}
