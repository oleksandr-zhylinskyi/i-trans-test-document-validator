<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Tests;

use ITransDocumentValidator\DocumentValidationPipeline;
use ITransDocumentValidator\Rules\DocumentContentLengthRule;
use ITransDocumentValidator\Rules\ProhibitedWordsRule;
use PHPUnit\Framework\TestCase;

class DocumentValidationPipelineTest extends TestCase
{
    public function testRunWithNoRulesReturnsValidResult(): void
    {
        $pipeline = new DocumentValidationPipeline();
        $document = new TestDocument('doc-1', 'any content', []);

        $result = $pipeline->run($document);

        $this->assertEmpty($result->getValidationErrors());
    }

    public function testRunPassesDocumentIdToResult(): void
    {
        $pipeline = new DocumentValidationPipeline();
        $document = new TestDocument('my-doc-id', 'content', []);

        $result = $pipeline->run($document);

        $this->assertSame('my-doc-id', $result->getDocumentId());
    }

    public function testRunCollectsErrorsFromFailingRules(): void
    {
        $pipeline = new DocumentValidationPipeline();
        $pipeline->pipe(new DocumentContentLengthRule(5));

        $document = new TestDocument('doc-1', 'this content is too long', []);

        $result = $pipeline->run($document);

        $this->assertCount(1, $result->getValidationErrors());
    }

    public function testRunCollectsErrorsFromMultipleFailingRules(): void
    {
        $pipeline = new DocumentValidationPipeline();
        $pipeline->pipe(new DocumentContentLengthRule(5));
        $pipeline->pipe(new ProhibitedWordsRule(['forbidden']));

        $document = new TestDocument('doc-1', 'this content is too long and has forbidden word', []);

        $result = $pipeline->run($document);

        $this->assertCount(2, $result->getValidationErrors());
    }

    public function testRunReturnsNoErrorsWhenAllRulesPass(): void
    {
        $pipeline = new DocumentValidationPipeline();
        $pipeline->pipe(new DocumentContentLengthRule(100));
        $pipeline->pipe(new ProhibitedWordsRule(['banned']));

        $document = new TestDocument('doc-1', 'clean short content', []);

        $result = $pipeline->run($document);

        $this->assertEmpty($result->getValidationErrors());
    }

    public function testPipeReturnsSelfForFluentChaining(): void
    {
        $pipeline = new DocumentValidationPipeline();

        $returned = $pipeline->pipe(new DocumentContentLengthRule(10));

        $this->assertSame($pipeline, $returned);
    }
}