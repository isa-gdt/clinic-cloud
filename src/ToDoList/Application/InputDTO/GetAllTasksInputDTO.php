<?php

declare(strict_types=1);

namespace Src\ToDoList\Application\InputDTO;

use Illuminate\Support\Facades\Validator;
use Src\Common\Application\Exception\ValidationException;

class GetAllTasksInputDTO
{
    private const LIMIT = 4;
    private const PAGE = 1;
    private int $limit;
    private int $page;

    public function __construct(array $data)
    {
        $this->validate($data);
        $this->limit = $data['limit'] ? (int)$data['limit'] : self::LIMIT;
        $this->page = $data['page'] ? (int)$data['page'] : self::PAGE;
    }

    private function validate(array $data): void
    {
        $messages = [
          'limit' => 'You need a valid limit!',
          'page' => 'You need a valid page!',
        ];

        $violations = Validator::make($data, [
            'limit' => 'nullable|min:1|numeric',
            'page' => 'nullable|min:1|numeric',
        ], $messages);

        if ($violations->fails()) {
            $errorMessages = [];
            foreach ($violations->errors()->all() as $error) {
                $errorMessages[] = $error;
            }
            throw new ValidationException($errorMessages);
        }
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function page(): int
    {
        return $this->page;
    }
}
