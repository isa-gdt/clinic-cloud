<?php

declare(strict_types=1);

namespace Src\ToDoList\Application\InputDTO;


use Illuminate\Support\Facades\Validator;
use Src\Common\Application\Exception\ValidationException;

class CreateTaskInputDTO
{
    private array $createdBy;
    private ?int $assignedTo;
    private string $text;
    private string $status;

    public function __construct(array $data, array $user)
    {
        $this->validate($data);
        $this->createdBy = $user;
        $this->assignedTo = $data['assigned_to'] ?? null;
        $this->text = $data['text'];
        $this->status = $data['status'];
    }

    private function validate(array $data): void
    {
        $messages = [
            'assigned_to' => 'You need a valid assignee!',
            'text' => 'You need a valid text!',
            'status' => 'You need a valid status!',
        ];
        $violations = Validator::make($data, [
            'assigned_to' => 'nullable|numeric',
            'text' => 'required|string|max:255',
            'status' => 'required|string|in:pending,in_progress,completed',
        ], $messages);

        if ($violations->fails()) {
            $errorMessages = [];
            foreach ($violations->errors()->all() as $error) {
                $errorMessages[] = $error;
            }
            throw new ValidationException($errorMessages);
        }
    }

    public function createdBy(): array
    {
        return $this->createdBy;
    }

    public function assignedTo(): ?int
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
}
