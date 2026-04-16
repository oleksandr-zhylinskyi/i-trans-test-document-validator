<?php

declare(strict_types=1);

namespace tests;

use ITransDocumentValidator\Contracts\ValidatableDocumentInterface;

readonly class TestDocument implements ValidatableDocumentInterface
{
    public function __construct(
        private string $id,
        private string $content,
        private array $metadata
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getMetaData(): array
    {
        return $this->metadata;
    }
}