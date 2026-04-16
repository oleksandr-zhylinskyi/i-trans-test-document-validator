<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Rules\Tenants\TestTenant;

use ITransDocumentValidator\Contracts\ValidatableDocumentInterface;
use ITransDocumentValidator\Contracts\DocumentValidationRuleInterface;

class HasAuthorRule implements DocumentValidationRuleInterface
{

    public function validate(ValidatableDocumentInterface $document): bool
    {
        return array_key_exists('author', $document->getMetaData());
    }

    public function getErrorMessage(): string
    {
        return 'Document must have author property in metadata';
    }
}