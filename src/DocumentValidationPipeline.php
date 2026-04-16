<?php

declare(strict_types=1);

namespace ITransDocumentValidator;

use ITransDocumentValidator\Contracts\DocumentValidationRuleInterface;
use ITransDocumentValidator\Contracts\ValidatableDocumentInterface;
use ITransDocumentValidator\ValidationErrors\DocumentValidationError;
use ITransDocumentValidator\ValidationErrors\DocumentValidationErrorSet;

final class DocumentValidationPipeline
{
    /**
     * @var DocumentValidationRuleInterface[]
     */
    private array $rules;

    public function pipe(DocumentValidationRuleInterface $rule): self
    {
        $this->rules[] = $rule;

        return $this;
    }

    public function run(ValidatableDocumentInterface $document): DocumentValidationResult
    {
        $errorSet = new DocumentValidationErrorSet();

        foreach ($this->rules as $rule) {
            $validated = $rule->validate($document);

            if (!$validated) {
                $errorSet->pushError(new DocumentValidationError($rule->getErrorMessage()));
            }
        }

        return new DocumentValidationResult($document->getId(), $errorSet);
    }
}