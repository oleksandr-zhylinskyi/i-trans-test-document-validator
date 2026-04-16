<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Contracts;

interface DocumentValidationRuleInterface
{
    public function validate(ValidatableDocumentInterface $document): bool;

    public function getErrorMessage(): string;
}