<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Exception;

class TokenCreationException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
