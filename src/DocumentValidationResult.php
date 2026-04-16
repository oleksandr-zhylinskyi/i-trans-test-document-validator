<?php

declare(strict_types=1);

namespace ITransDocumentValidator;

use ITransDocumentValidator\ValidationErrors\DocumentValidationError;
use ITransDocumentValidator\ValidationErrors\DocumentValidationErrorSet;

class DocumentValidationResult
{
    protected bool $isValid = true;

    public function __construct(
        protected string $documentId,
        protected DocumentValidationErrorSet $errorSet,
    )
    {
        $this->isValid = !$this->errorSet->hasErrors();
    }

    /**
     * @return DocumentValidationError[]
     */
    public function getValidationErrors(): array
    {
        return $this->errorSet->getErrors();
    }

    /**
     * @return string[]
     */
    public function getErrorMessages(): array
    {
        return array_map(
            fn (DocumentValidationError $validationError): string => $validationError->getMessage(),
            $this->errorSet->getErrors()
        );
    }

    public function getDocumentId(): string
    {
        return $this->documentId;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }
}