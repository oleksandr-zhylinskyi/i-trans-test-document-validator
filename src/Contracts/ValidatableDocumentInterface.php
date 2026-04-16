<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Contracts;

interface ValidatableDocumentInterface
{
    public function getId(): string;

    public function getContent(): string;

    public function getMetaData(): array;
}