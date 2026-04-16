<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Tests\Rules;

use ITransDocumentValidator\Rules\ProhibitedWordsRule;
use PHPUnit\Framework\TestCase;
use ITransDocumentValidator\Tests\TestDocument;

class ProhibitedWordsRuleTest extends TestCase
{
    public function testPassesWhenNoProhibitedWordsPresent(): void
    {
        $rule = new ProhibitedWordsRule(['spam', 'banned']);
        $document = new TestDocument('doc-1', 'This is a clean document.', []);

        $this->assertTrue($rule->validate($document));
    }

    public function testFailsWhenOneProhibitedWordIsFound(): void
    {
        $rule = new ProhibitedWordsRule(['spam', 'banned']);
        $document = new TestDocument('doc-1', 'This document contains spam.', []);

        $this->assertFalse($rule->validate($document));
    }

    public function testFailsWhenMultipleProhibitedWordsAreFound(): void
    {
        $rule = new ProhibitedWordsRule(['spam', 'banned']);
        $document = new TestDocument('doc-1', 'spam and banned content', []);

        $this->assertFalse($rule->validate($document));
    }

    public function testErrorMessageListsFoundProhibitedWords(): void
    {
        $rule = new ProhibitedWordsRule(['spam', 'banned']);
        $document = new TestDocument('doc-1', 'spam and banned content', []);

        $rule->validate($document);

        $this->assertSame(
            'Document contains prohibited words: spam, banned',
            $rule->getErrorMessage()
        );
    }

    public function testErrorMessageListsOnlyFoundWords(): void
    {
        $rule = new ProhibitedWordsRule(['spam', 'banned', 'other']);
        $document = new TestDocument('doc-1', 'only spam here', []);

        $rule->validate($document);

        $this->assertSame(
            'Document contains prohibited words: spam',
            $rule->getErrorMessage()
        );
    }

    public function testEmptyProhibitedWordsListAlwaysPasses(): void
    {
        $rule = new ProhibitedWordsRule([]);
        $document = new TestDocument('doc-1', 'anything goes', []);

        $this->assertTrue($rule->validate($document));
    }
}