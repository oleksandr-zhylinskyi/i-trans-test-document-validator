<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Tests\Factory;

use ITransDocumentValidator\Contracts\DocumentValidatorInterface;
use ITransDocumentValidator\Factory\DocumentValidatorFactory;
use ITransDocumentValidator\Rules\DocumentContentLengthRule;
use ITransDocumentValidator\Rules\ProhibitedWordsRule;
use ITransDocumentValidator\Tests\TestContext;
use ITransDocumentValidator\Tests\TestDocument;
use PHPUnit\Framework\TestCase;

class DocumentValidatorFactoryTest extends TestCase
{
    private DocumentValidatorFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new DocumentValidatorFactory();
    }

    public function testFromArrayReturnsValidatorInstance(): void
    {
        $validator = $this->factory->fromArray([]);

        $this->assertInstanceOf(DocumentValidatorInterface::class, $validator);
    }

    public function testFromArrayWithNoRulesProducesValidResult(): void
    {
        $validator = $this->factory->fromArray([]);
        $document = new TestDocument('doc-1', 'any content', []);

        $result = $validator->validate($document);

        $this->assertEmpty($result->getValidationErrors());
    }

    public function testFromArrayAppliesProvidedRules(): void
    {
        $validator = $this->factory->fromArray([
            new DocumentContentLengthRule(5),
        ]);

        $document = new TestDocument('doc-1', 'this is way too long', []);
        $result = $validator->validate($document);

        $this->assertCount(1, $result->getValidationErrors());
    }

    public function testFromArrayAppliesMultipleRules(): void
    {
        $validator = $this->factory->fromArray([
            new DocumentContentLengthRule(5),
            new ProhibitedWordsRule(['forbidden']),
        ]);

        $document = new TestDocument('doc-1', 'too long and forbidden', []);
        $result = $validator->validate($document);

        $this->assertCount(2, $result->getValidationErrors());
    }

    public function testFromBelongsToTenantReturnsValidatorInstance(): void
    {
        $context = new TestContext();
        $context->setTenantId('test-tenant');

        $validator = $this->factory->fromBelongsToTenant($context);

        $this->assertInstanceOf(DocumentValidatorInterface::class, $validator);
    }

    public function testFromBelongsToTenantWithKnownTenantUsesItsRules(): void
    {
        $context = new TestContext();
        $context->setTenantId('test-tenant');

        $validator = $this->factory->fromBelongsToTenant($context);

        // document missing 'author' metadata should fail HasAuthorRule (test-tenant specific)
        $document = new TestDocument('doc-1', 'short', []);
        $result = $validator->validate($document);

        $messages = $result->getErrorMessages();
        $this->assertContains('Document must have author property in metadata', $messages);
    }

    public function testFromBelongsToTenantWithUnknownTenantFallsBackToDefaults(): void
    {
        $context = new TestContext();
        $context->setTenantId('unknown-tenant');

        // should not throw — just falls back to default rules
        $validator = $this->factory->fromBelongsToTenant($context);

        $this->assertInstanceOf(DocumentValidatorInterface::class, $validator);
    }
}