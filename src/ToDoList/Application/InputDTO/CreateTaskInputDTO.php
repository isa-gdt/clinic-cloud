<?php

declare(strict_types=1);

namespace Src\ToDoList\Application\InputDTO;


use Illuminate\Support\Facades\Validator;
use Src\Common\Application\Exception\ValidationException;

class CreateTaskInputDTO
{
    private int $createdBy;
    private ?int $assignedTo;
    private string $text;
    private string $status;

    public function __construct(array $data)
    {
        $this->validate($data);
        $this->createdBy = $data['created_by'];
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

    public function createdBy(): int
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
