<?php

namespace App\DTOs;

use App\Contracts\DataTransferObject;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class DTO implements DataTransferObject
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return collect($this)->mapWithKeys(fn($value, $key) => [Str::snake($key) => $value]
        )->toArray();
    }

    /**
     * Get the (concrete) data transfer object from the request.
     *
     * @param FormRequest $formRequest
     * @return static
     */
    public static function fromRequest(FormRequest $formRequest): static
    {
        return new static(
            ...collect($formRequest->validated())
            ->mapWithKeys(
                fn($value, $key) => [Str::camel($key) => $value]
            )->toArray()
        );
    }
}
