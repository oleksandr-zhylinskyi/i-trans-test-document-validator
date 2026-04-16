<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Tests\Rules;

use ITransDocumentValidator\Tests\TestDocument;
use ITransDocumentValidator\Rules\DocumentContentLengthRule;
use PHPUnit\Framework\TestCase;
class DocumentContentLengthRuleTest extends TestCase
{
    public function testPassesWhenContentIsShorterThanMax(): void
    {
        $rule = new DocumentContentLengthRule(100);
        $document = new TestDocument('doc-1', 'short content', []);

        $this->assertTrue($rule->validate($document));
    }

    public function testPassesWhenContentIsExactlyMaxLength(): void
    {
        $content = str_repeat('a', 100);
        $rule = new DocumentContentLengthRule(100);
        $document = new TestDocument('doc-1', $content, []);

        $this->assertTrue($rule->validate($document));
    }

    public function testFailsWhenContentExceedsMax(): void
    {
        $content = str_repeat('a', 101);
        $rule = new DocumentContentLengthRule(100);
        $document = new TestDocument('doc-1', $content, []);

        $this->assertFalse($rule->validate($document));
    }

    public function testErrorMessageContainsActualAndMaxLengths(): void
    {
        $content = str_repeat('a', 150);
        $rule = new DocumentContentLengthRule(100);
        $document = new TestDocument('doc-1', $content, []);

        $rule->validate($document);

        $this->assertSame(
            'Document contains 150 characters, 100 max is allowed.',
            $rule->getErrorMessage()
        );
    }
}