<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Tests\Rules;

use ITransDocumentValidator\Rules\Tenants\TestTenant\HasAuthorRule;
use PHPUnit\Framework\TestCase;
use ITransDocumentValidator\Tests\TestDocument;

class HasAuthorRuleTest extends TestCase
{
    public function testPassesWhenAuthorIsPresentInMetadata(): void
    {
        $rule = new HasAuthorRule();
        $document = new TestDocument('doc-1', 'content', ['author' => 'Jane Doe']);

        $this->assertTrue($rule->validate($document));
    }

    public function testFailsWhenAuthorIsMissingFromMetadata(): void
    {
        $rule = new HasAuthorRule();
        $document = new TestDocument('doc-1', 'content', ['title' => 'Some Title']);

        $this->assertFalse($rule->validate($document));
    }

    public function testFailsWhenMetadataIsEmpty(): void
    {
        $rule = new HasAuthorRule();
        $document = new TestDocument('doc-1', 'content', []);

        $this->assertFalse($rule->validate($document));
    }

    public function testErrorMessageDescribesRequirement(): void
    {
        $rule = new HasAuthorRule();

        $this->assertSame(
            'Document must have author property in metadata',
            $rule->getErrorMessage()
        );
    }
}