<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Tests;

use ITransDocumentValidator\Contracts\DocumentValidationRuleInterface;
use ITransDocumentValidator\Rules\DocumentContentLengthRule;
use ITransDocumentValidator\Rules\MetaDataFieldsRule;
use ITransDocumentValidator\Rules\ProhibitedWordsRule;
use ITransDocumentValidator\Rules\Tenants\TestTenant\HasAuthorRule;
use ITransDocumentValidator\TenantConfigLoader;
use PHPUnit\Framework\TestCase;

class TenantConfigLoaderTest extends TestCase
{
    private TenantConfigLoader $loader;

    protected function setUp(): void
    {
        $this->loader = new TenantConfigLoader();
    }

    public function testLoadRulesForUnknownTenantReturnsDefaultRules(): void
    {
        $rules = $this->loader->loadRules('non-existent-tenant');

        $this->assertIsArray($rules);
        $this->assertNotEmpty($rules);

        $ruleClasses = array_map(fn ($r) => get_class($r), $rules);
        $this->assertContains(DocumentContentLengthRule::class, $ruleClasses);
        $this->assertContains(MetaDataFieldsRule::class, $ruleClasses);
        $this->assertContains(ProhibitedWordsRule::class, $ruleClasses);
    }

    public function testLoadRulesForKnownTenantReturnsMergedRules(): void
    {
        $rules = $this->loader->loadRules('test-tenant');

        $this->assertIsArray($rules);

        $ruleClasses = array_map(fn ($r) => get_class($r), $rules);

        // default rules are present
        $this->assertContains(DocumentContentLengthRule::class, $ruleClasses);
        $this->assertContains(MetaDataFieldsRule::class, $ruleClasses);
        $this->assertContains(ProhibitedWordsRule::class, $ruleClasses);

        // tenant-specific rule is also present
        $this->assertContains(HasAuthorRule::class, $ruleClasses);
    }

    public function testLoadRulesForKnownTenantHasMoreRulesThanDefaults(): void
    {
        $defaultRules = $this->loader->loadRules('non-existent-tenant');
        $tenantRules = $this->loader->loadRules('test-tenant');

        $this->assertGreaterThan(count($defaultRules), count($tenantRules));
    }

    public function testLoadRulesReturnsRuleInstances(): void
    {
        $rules = $this->loader->loadRules('non-existent-tenant');

        foreach ($rules as $rule) {
            $this->assertInstanceOf(DocumentValidationRuleInterface::class, $rule);
        }
    }
}