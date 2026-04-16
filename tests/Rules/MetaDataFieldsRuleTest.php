<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Tests\Rules;

use ITransDocumentValidator\Rules\MetaDataFieldsRule;
use PHPUnit\Framework\TestCase;
use ITransDocumentValidator\Tests\TestDocument;
class MetaDataFieldsRuleTest extends TestCase
{
    public function testAlwaysValidWhenRequiredFieldsAreProvided(): void
    {
        $rule = new MetaDataFieldsRule(['author']);
        $document = new TestDocument('doc-1', 'content', ['author' => 'John']);

        $this->assertTrue($rule->validate($document));
    }

    public function testPassesWhenNoFieldsAreRequired(): void
    {
        $rule = new MetaDataFieldsRule([]);
        $document = new TestDocument('doc-1', 'content', []);

        $this->assertTrue($rule->validate($document));
    }

    public function testErrorMessageListsMissingFields(): void
    {
        $rule = new MetaDataFieldsRule(['author', 'title']);
        $document = new TestDocument(
            'doc-1',
            'content',
            ['foo' => 'Bar', 'fizz' => 'Doc']
        );

        $rule->validate($document);

        $this->assertSame(
            'The following fields are missing: author, title',
            $rule->getErrorMessage()
        );
    }
}