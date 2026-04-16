<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Tests\ValidationErrors;

use ITransDocumentValidator\ValidationErrors\DocumentValidationError;
use ITransDocumentValidator\ValidationErrors\DocumentValidationErrorSet;
use PHPUnit\Framework\TestCase;
class DocumentValidationErrorSetTest extends TestCase
{
    public function testHasNoErrorsByDefault(): void
    {
        $set = new DocumentValidationErrorSet();

        $this->assertFalse($set->hasErrors());
        $this->assertSame([], $set->getErrors());
    }
    public function testPushErrorAddsToSet(): void
    {
        $set = new DocumentValidationErrorSet();
        $error = new DocumentValidationError('bad content');

        $set->pushError($error);

        $this->assertTrue($set->hasErrors());
        $this->assertCount(1, $set->getErrors());
        $this->assertSame($error, $set->getErrors()[0]);
    }
    public function testMultipleErrorsAreAccumulated(): void
    {
        $set = new DocumentValidationErrorSet();
        $set->pushError(new DocumentValidationError('error one'));
        $set->pushError(new DocumentValidationError('error two'));

        $this->assertCount(2, $set->getErrors());
    }
}