<?php

declare(strict_types=1);

namespace Src\ToDoList\Application\InputDTO;

use Illuminate\Support\Facades\Validator;
use Src\Common\Application\Exception\ValidationException;

class DeleteTaskInputDTO
{
    private int $id;

    public function __construct(array $data)
    {
        $this->validate($data);
        $this->id = (int)$data['id'];
    }

    private function validate(array $data): void
    {
        $messages = [
            'id' => 'You need a valid id!'
        ];

        $violations = Validator::make($data, [
            'id' => 'required|numeric'
        ],$messages);

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
}
