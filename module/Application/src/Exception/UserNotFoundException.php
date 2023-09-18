<?php

declare(strict_types=1);

namespace Application\Exception;

use Exception;
use Throwable;

class UserNotFoundException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('User not found');
    }
}
