<?php

declare(strict_types=1);

namespace Src\Auth\Application\InputDTO;

use Illuminate\Support\Facades\Validator;
use Src\Common\Application\Exception\ValidationException;

class LoginInputDTO
{
    private string $email;
    private string $password;

    public function __construct(array $data)
    {
        $this->validate($data);
        $this->email = $data['email'];
        $this->password = $data['password'];
    }

    private function validate(array $data): void
    {
        $messages = [
            'email' => 'You need a valid email address!',
            'password' => 'You need a valid password!',
        ];

        $violations = Validator::make($data, [
            'email' => 'required|string|email',
            'password' => 'required',
        ], $messages);

        if ($violations->fails()) {
            $errorMessages = [];
            foreach ($violations->errors()->all() as $error) {
                $errorMessages[] = $error;

            }
            throw new ValidationException($errorMessages);
        }
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}
