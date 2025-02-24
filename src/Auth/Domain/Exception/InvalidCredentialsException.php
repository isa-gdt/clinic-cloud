<?php

declare(strict_types=1);

namespace Src\Auth\Domain\Exception;

class InvalidCredentialsException extends \Exception
{
    const MESSAGE = 'Invalid credentials';
    public function __construct()
    {
        parent::__construct(self::MESSAGE, 401);
    }
}
