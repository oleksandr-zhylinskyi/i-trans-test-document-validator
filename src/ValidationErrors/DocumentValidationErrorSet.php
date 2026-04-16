<?php

declare(strict_types=1);

namespace ITransDocumentValidator\ValidationErrors;

class DocumentValidationErrorSet
{
    protected array $errors = [];

    public function pushError(DocumentValidationError $documentValidationError): void
    {
        $this->errors[] = $documentValidationError;
    }

    /**
     * @return DocumentValidationError[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }
}