<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Rules;

use ITransDocumentValidator\Contracts\DocumentValidationRuleInterface;
use ITransDocumentValidator\Contracts\ValidatableDocumentInterface;
use ITransDocumentValidator\Traits\BuildsErrorMessageTrait;

class MetaDataFieldsRule implements DocumentValidationRuleInterface
{
    use BuildsErrorMessageTrait;

    public function __construct(private readonly array $metaDataFields)
    {
    }

    public function validate(ValidatableDocumentInterface $document): bool
    {
        $valid = true;

        $fieldsMissing = [];

        foreach ($this->metaDataFields as $metaDataField) {
            if (!array_key_exists($metaDataField, $document->getMetaData())) {
                $fieldsMissing[] = $metaDataField;
                $valid = false;
            }
        }

        $this->errorMessage = sprintf(
            'The following fields are missing: %s',
            implode(', ', $fieldsMissing)
        );

        return $valid;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}