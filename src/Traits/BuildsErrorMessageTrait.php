<?php

declare(strict_types=1);

namespace ITransDocumentValidator\Traits;

trait BuildsErrorMessageTrait
{
    protected string $errorMessage = '' {
        set {
            $this->errorMessage = $value;
        }
    }
}