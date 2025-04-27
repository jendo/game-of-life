<?php

declare(strict_types=1);

namespace App\Game\Input\Validation;

use Exception;

class InvalidStateException extends Exception
{
    /**
     * @var Error[]
     */
    private array $errors;

    /**
     * @param Error[] $errors
     * @return self
     */
    public static function createFromErrors(array $errors): self
    {
        $self = new self('Invalid state.');
        $self->errors = $errors;

        return $self;
    }

    /**
     * @return Error[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
