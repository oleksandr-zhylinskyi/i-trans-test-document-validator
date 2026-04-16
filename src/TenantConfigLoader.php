<?php

declare(strict_types=1);

namespace ITransDocumentValidator;

class TenantConfigLoader
{
    public function loadRules(string $tenantId): array
    {
        $tenantConfigPath = sprintf(
            '%s/config/tenants/%s.php',
            __DIR__,
            $tenantId
        );

        $defaultRulesPath = __DIR__ . '/config/default-rules.php';

        if (!file_exists($tenantConfigPath)) {
            return require $defaultRulesPath;
        }


        return array_merge(
            require $defaultRulesPath,
            require $tenantConfigPath,
        );
    }
}