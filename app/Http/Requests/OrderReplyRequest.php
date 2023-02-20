<?php

namespace App\Http\Requests;

use App\Models\Order;
use App\Rules\OrderCanOnlyReplyOnceRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderReplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        /** @var Order $order */
        $order = $this->route('order');
        return [
            Order::REPLY_MESSAGE => ['required', 'string', 'max:255',
                new OrderCanOnlyReplyOnceRule($order)
            ],
        ];
    }
}
