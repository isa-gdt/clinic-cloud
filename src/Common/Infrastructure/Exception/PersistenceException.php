<?php

declare(strict_types = 1);

namespace Src\Common\Infrastructure\Exception;

class PersistenceException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
