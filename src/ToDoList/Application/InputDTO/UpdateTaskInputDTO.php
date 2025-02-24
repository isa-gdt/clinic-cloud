<?php

declare(strict_types=1);

namespace Src\ToDoList\Application\InputDTO;

use Illuminate\Support\Facades\Validator;
use Src\Common\Application\Exception\ValidationException;

class UpdateTaskInputDTO
{
    private int $id;
    private ?int $assignedTo;
    private ?string $text;
    private ?string $status;

    public function __construct(array $data)
    {
        $this->validate($data);
        $this->id = (int)$data['id'];
        $this->assignedTo = $data['assigned_to'] ?? null;
        $this->text = $data['text'];
        $this->status = $data['status'];
    }
    private function validate(array $data): void
    {
        $messages = [
            'id' => 'You need a valid id!',
            'assigned_to' => 'You need a valid assignee!',
            'text' => 'You need a valid text!',
            'status' => 'You need a valid status!',
        ];
        $violations = Validator::make($data, [
            'id' => 'required|numeric',
            'assigned_to' => 'nullable|numeric',
            'text' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:pending,in_progress,completed',
        ], $messages);

        if ($violations->fails()) {
            $errorMessages = [];
            foreach ($violations->errors()->all() as $error) {
                $errorMessages[] = $error;
            }
            throw new ValidationException($errorMessages);
        }
    }

    public function id(): int
    {
        return $this->id;
    }

    public function assignedTo(): ?int
    {
        return $this->assignedTo;
    }

    public function text(): ?string
    {
        return $this->text;
    }

    public function status(): ?string
    {
        return $this->status;
    }
}
