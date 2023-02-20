<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            Order::ID => $this->{Order::ID},
            Order::MAIL_ID => $this->{Order::MAIL_ID},
            Order::SUBJECT => $this->{Order::SUBJECT},
            Order::BODY => $this->{Order::BODY},
            Order::RECEIVED_AT => $this->{Order::RECEIVED_AT},
            Order::RECEIVED_FROM => $this->{Order::RECEIVED_FROM},
            Order::REPLIED_AT => $this->{Order::REPLIED_AT},
            Order::REPLY_MESSAGE => $this->{Order::REPLY_MESSAGE},
            Order::SEEN_AT => $this->{Order::SEEN_AT},
        ];
    }
}

