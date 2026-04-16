<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Tests;

use ITransDocumentValidator\DocumentValidationResult;
use ITransDocumentValidator\ValidationErrors\DocumentValidationError;
use ITransDocumentValidator\ValidationErrors\DocumentValidationErrorSet;
use PHPUnit\Framework\TestCase;

class DocumentValidationResultTest extends TestCase
{
    public function testDocumentIdIsAccessible(): void
    {
        $result = new DocumentValidationResult('doc-abc', new DocumentValidationErrorSet());

        $this->assertSame('doc-abc', $result->getDocumentId());
    }

    public function testGetValidationErrorsReturnsEmptyArrayWhenNoErrors(): void
    {
        $result = new DocumentValidationResult('doc-1', new DocumentValidationErrorSet());

        $this->assertSame([], $result->getValidationErrors());
    }

    public function testGetValidationErrorsReturnsErrors(): void
    {
        $errorSet = new DocumentValidationErrorSet();
        $error = new DocumentValidationError('bad content');
        $errorSet->pushError($error);

        $result = new DocumentValidationResult('doc-1', $errorSet);

        $this->assertCount(1, $result->getValidationErrors());
        $this->assertSame($error, $result->getValidationErrors()[0]);
    }

    public function testGetErrorMessagesReturnsStringMessages(): void
    {
        $errorSet = new DocumentValidationErrorSet();
        $errorSet->pushError(new DocumentValidationError('error one'));
        $errorSet->pushError(new DocumentValidationError('error two'));

        $result = new DocumentValidationResult('doc-1', $errorSet);

        $this->assertSame(['error one', 'error two'], $result->getErrorMessages());
    }

    public function testGetErrorMessagesReturnsEmptyArrayWhenNoErrors(): void
    {
        $result = new DocumentValidationResult('doc-1', new DocumentValidationErrorSet());

        $this->assertSame([], $result->getErrorMessages());
    }

    public function testIsValidReturnsTrueWhenNoErrors(): void
    {
        $result = new DocumentValidationResult('doc-1', new DocumentValidationErrorSet());

        $this->assertTrue($result->isValid());
    }

    public function testIsValidReturnsFalseWhenErrorsArePresent(): void
    {
        $errorSet = new DocumentValidationErrorSet();
        $errorSet->pushError(new DocumentValidationError('something is wrong'));

        $result = new DocumentValidationResult('doc-1', $errorSet);

        $this->assertFalse($result->isValid());
    }
}