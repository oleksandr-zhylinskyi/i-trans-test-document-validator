<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Rules;

use ITransDocumentValidator\Contracts\DocumentValidationRuleInterface;
use ITransDocumentValidator\Contracts\ValidatableDocumentInterface;
use ITransDocumentValidator\Traits\BuildsErrorMessageTrait;

class DocumentContentLengthRule implements DocumentValidationRuleInterface
{
    use BuildsErrorMessageTrait;

    public function __construct(private readonly int $maxLength)
    {

    }

    public function validate(ValidatableDocumentInterface $document): bool
    {
        $valid = true;

        $documentLength = strlen($document->getContent());

        if ($documentLength > $this->maxLength) {
            $valid = false;
            $this->errorMessage = sprintf(
                'Document contains %d characters, %d max is allowed.',
                $documentLength,
                $this->maxLength,
            );
        }

        return $valid;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}