<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Rules;

use ITransDocumentValidator\Traits\BuildsErrorMessageTrait;
use ITransDocumentValidator\Contracts\ValidatableDocumentInterface;
use ITransDocumentValidator\Contracts\DocumentValidationRuleInterface;

class ProhibitedWordsRule implements DocumentValidationRuleInterface
{
    use BuildsErrorMessageTrait;

    public function __construct(private readonly array $words)
    {
    }

    public function validate(ValidatableDocumentInterface $document): bool
    {
        if (empty($this->words)) {
            return true;
        }

        $pattern = '/\b(' . implode('|', array_map('preg_quote', $this->words)) . ')\b/i';

        preg_match_all($pattern, $document->getContent(), $matches);

        $prohibitedWordFound = array_unique($matches[1]);

        if (!empty($prohibitedWordFound)) {
            $this->errorMessage = sprintf(
                'Document contains prohibited words: %s',
                implode(', ', $prohibitedWordFound)
            );
            return false;
        }

        return true;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}