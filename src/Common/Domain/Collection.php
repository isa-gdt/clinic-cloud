<?php

declare(strict_types=1);

namespace Src\Common\Domain;

class Collection
{
    public function __construct(protected array $collection)
    {
    }

    public function collection(): array
    {
        return $this->collection;
    }
}
