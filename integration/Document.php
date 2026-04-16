<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Integration;

use ITransDocumentValidator\Contracts\ValidatableDocumentInterface;

readonly class Document implements ValidatableDocumentInterface
{
    public function __construct(
        private string $id,
        private string $content,
        private array $metaData
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
        return $this->metaData;
    }
}