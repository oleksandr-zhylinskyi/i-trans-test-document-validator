<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Contracts;

interface DocumentValidatorFactoryInterface
{
    public function fromArray(array $rules): DocumentValidatorInterface;

    public function fromBelongsToTenant(BelongsToTenantInterface $context): DocumentValidatorInterface;
}