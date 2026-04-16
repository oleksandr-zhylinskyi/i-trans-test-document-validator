<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Factory;

use ITransDocumentValidator\Contracts\BelongsToTenantInterface;
use ITransDocumentValidator\Contracts\DocumentValidatorFactoryInterface;
use ITransDocumentValidator\Contracts\DocumentValidatorInterface;
use ITransDocumentValidator\DocumentValidationPipeline;
use ITransDocumentValidator\DocumentValidator;
use ITransDocumentValidator\TenantConfigLoader;

class DocumentValidatorFactory implements DocumentValidatorFactoryInterface
{
    public function fromArray(array $rules): DocumentValidatorInterface
    {
        $pipeline = new DocumentValidationPipeline();

        foreach ($rules as $rule) {
            $pipeline->pipe($rule);
        }

        return new DocumentValidator($pipeline);
    }

    public function fromBelongsToTenant(BelongsToTenantInterface $context): DocumentValidatorInterface
    {
        $configLoader = new TenantConfigLoader();

        $rules = $configLoader->loadRules($context->getTenantId());

        return $this->fromArray($rules);
    }
}