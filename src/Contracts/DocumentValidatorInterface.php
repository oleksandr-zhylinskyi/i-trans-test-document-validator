<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Contracts;

use ITransDocumentValidator\DocumentValidationResult;

interface DocumentValidatorInterface
{
    public function validate(ValidatableDocumentInterface $document): DocumentValidationResult;
}