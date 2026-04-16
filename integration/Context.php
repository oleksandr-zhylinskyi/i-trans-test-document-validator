<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Integration;

use ITransDocumentValidator\Traits\BelongsToTenantTrait;
use ITransDocumentValidator\Contracts\BelongsToTenantInterface;

class Context implements BelongsToTenantInterface
{
    use BelongsToTenantTrait;
}