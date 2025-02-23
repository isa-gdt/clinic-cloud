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

    /*public function toArray(): array
    {
        return array_map(function ($collection) {
            return $collection->toArray();
        }, $this->collection);
    }

    public function map(callable $callback): static
    {
        return new static(array_map($callback, $this->collection));
    }*/
}
