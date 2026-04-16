<?php

declare(strict_types=1);

namespace tests;

use ITransDocumentValidator\Contracts\BelongsToTenantInterface;
use ITransDocumentValidator\Traits\BelongsToTenantTrait;

final class TestContext implements BelongsToTenantInterface
{
    use BelongsToTenantTrait;
}