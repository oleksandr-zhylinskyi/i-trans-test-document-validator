<?php

declare(strict_types=1);

namespace ITransDocumentValidator;

use ITransDocumentValidator\Contracts\DocumentValidatorInterface;
use ITransDocumentValidator\Contracts\ValidatableDocumentInterface;
class DocumentValidator implements DocumentValidatorInterface
{
    public function __construct(protected DocumentValidationPipeline $pipeline)
    {
    }

    public function validate(ValidatableDocumentInterface $document): DocumentValidationResult
    {
        return $this->pipeline->run($document);
    }
}