<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Tests\ValidationErrors;

use ITransDocumentValidator\ValidationErrors\DocumentValidationError;
use PHPUnit\Framework\TestCase;

class DocumentValidationErrorTest extends TestCase
{
    public function testGetMessageReturnsConstructedMessage(): void
    {
        $error = new DocumentValidationError('Something went wrong');

        $this->assertSame('Something went wrong', $error->getMessage());
    }
}