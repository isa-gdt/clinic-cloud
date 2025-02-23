<?php

declare(strict_types=1);

namespace Src\ToDoList\Domain;

class Task
{
    public function __construct(
        private ?int $id,
        private string $createdBy,
        private ?string $assignedTo,
        private string $text,
        private string $status,
        private string $createdAt,
        private string $updatedAt,
    )
    {
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function createdBy(): string
    {
        return $this->createdBy;
    }

    public function assignedTo(): ?string
    {
        return $this->assignedTo;
    }

    public function text(): string
    {
        return $this->text;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }

    public function updatedAt(): string
    {
        return $this->updatedAt;
    }
}
