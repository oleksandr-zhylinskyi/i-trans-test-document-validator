<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Rules;

use ITransDocumentValidator\Contracts\DocumentValidationRuleInterface;
use ITransDocumentValidator\Contracts\ValidatableDocumentInterface;
use ITransDocumentValidator\Traits\BuildsErrorMessageTrait;

class ProhibitedWordsRule implements DocumentValidationRuleInterface
{
    use BuildsErrorMessageTrait;

    public function __construct(private array $words)
    {
    }

    public function validate(ValidatableDocumentInterface $document): bool
    {
        $valid = true;

        $prohibitedWordFound = [];

        foreach ($this->words as $prohibitedWord) {
            if (str_contains($document->getContent(), $prohibitedWord)) {
                $prohibitedWordFound[] = $prohibitedWord;
                $valid = false;
            }
        }

        $this->errorMessage = sprintf(
            'Document contains prohibited words: %s',
            implode(', ', $prohibitedWordFound),
        );

        return $valid;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}