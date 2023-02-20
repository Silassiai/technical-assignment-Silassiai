<?php

namespace App\Rules;

use App\Models\Order;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class OrderCanOnlyReplyOnceRule implements ValidationRule
{
    /**
     * The order instance we are replying.
     *
     * @param Order $order
     */
    public function __construct(
        private readonly Order $order,
    ) {
    }

    /**
     * Fails if the orders has already been replied to.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(null !== $this->order->{Order::REPLIED_AT}){
            $fail(trans('order.validation.reply_message.already'));
        }
    }
}
