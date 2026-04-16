<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Contracts;

interface BelongsToTenantInterface
{
    public function getTenantId(): string;
}