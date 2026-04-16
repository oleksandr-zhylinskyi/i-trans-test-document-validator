<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Tests;

use ITransDocumentValidator\DocumentValidationPipeline;
use ITransDocumentValidator\DocumentValidator;
use ITransDocumentValidator\Rules\DocumentContentLengthRule;
use ITransDocumentValidator\Rules\ProhibitedWordsRule;
use PHPUnit\Framework\TestCase;

class DocumentValidatorTest extends TestCase
{
    public function testValidateReturnsResultWithCorrectDocumentId(): void
    {
        $validator = new DocumentValidator(new DocumentValidationPipeline());
        $document = new TestDocument('doc-xyz', 'content', []);

        $result = $validator->validate($document);

        $this->assertSame('doc-xyz', $result->getDocumentId());
    }

    public function testValidateReturnsNoErrorsWhenAllRulesPass(): void
    {
        $pipeline = new DocumentValidationPipeline()
            ->pipe(new DocumentContentLengthRule(100))
            ->pipe(new ProhibitedWordsRule(['spam']));

        $validator = new DocumentValidator($pipeline);
        $document = new TestDocument('doc-1', 'clean short text', []);

        $result = $validator->validate($document);

        $this->assertEmpty($result->getValidationErrors());
    }

    public function testValidateReturnsErrorsWhenRuleFails(): void
    {
        $pipeline = new DocumentValidationPipeline()
            ->pipe(new DocumentContentLengthRule(5));

        $validator = new DocumentValidator($pipeline);
        $document = new TestDocument('doc-1', 'this is way too long', []);

        $result = $validator->validate($document);

        $this->assertCount(1, $result->getValidationErrors());
    }

    public function testValidateCollectsErrorsFromMultipleFailingRules(): void
    {
        $pipeline = new DocumentValidationPipeline()
            ->pipe(new DocumentContentLengthRule(5))
            ->pipe(new ProhibitedWordsRule(['forbidden']));

        $validator = new DocumentValidator($pipeline);
        $document = new TestDocument('doc-1', 'too long and forbidden', []);

        $result = $validator->validate($document);

        $this->assertCount(2, $result->getValidationErrors());
    }
}