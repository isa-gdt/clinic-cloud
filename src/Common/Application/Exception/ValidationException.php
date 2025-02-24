<?php

declare(strict_types=1);

namespace Src\Common\Application\Exception;

class ValidationException extends \Exception
{
    protected const MESSAGE = 'Validation Error';
    public function __construct(private readonly array $errors)
    {
        parent::__construct(self::MESSAGE, 400);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
