<?php

declare(strict_types=1);

namespace ITransDocumentValidator\ValidationErrors;

readonly class DocumentValidationError
{
    public function __construct(private string $message)
    {
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}