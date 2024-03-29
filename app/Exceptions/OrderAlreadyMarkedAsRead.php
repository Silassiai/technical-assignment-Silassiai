<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class OrderAlreadyMarkedAsRead extends Exception
{
    /**
     * @param string $message
     */
    public function __construct(string $message = "Order has already been marked as read.")
    {
        parent::__construct($message, 422);
    }
}
