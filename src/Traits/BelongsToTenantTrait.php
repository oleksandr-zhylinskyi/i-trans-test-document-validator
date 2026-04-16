<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Traits;

trait BelongsToTenantTrait
{
    protected string $tenantId;

    public function getTenantId(): string
    {
        return $this->tenantId;
    }

    public function setTenantId(string $tenantId): void
    {
        $this->tenantId = $tenantId;
    }
}