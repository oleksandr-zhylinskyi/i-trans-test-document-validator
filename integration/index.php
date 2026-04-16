<?php

require_once __DIR__ . '/../vendor/autoload.php';

use ITransDocumentValidator\Factory\DocumentValidatorFactory;
use ITransDocumentValidator\Integration\Context;
use ITransDocumentValidator\Integration\Document;

$document = new Document(
    'doc-123',
    'Content with some prohibited words: forbidden, kek, iknowright.',
    ['author' => 'John Doe']
);

$context = new Context();
$context->setTenantId('test-tenant');

$factory = new DocumentValidatorFactory();
$validator = $factory->fromBelongsToTenant($context);

$result = $validator->validate($document);

if (!$result->isValid()) {
    foreach ($result->getErrorMessages() as $errorMessage) {
        echo $errorMessage . PHP_EOL;
    }
} else {
    echo 'Validation passed';
}

echo str_repeat('-', 100) . PHP_EOL;

$document = new Document(
    'doc-123',
    'Content with some prohibited words: forbidden, kek, iknowright.',
    ['foo' => 'John Doe']
);

$result = $validator->validate($document);

if (!$result->isValid()) {
    foreach ($result->getErrorMessages() as $errorMessage) {
        echo $errorMessage . PHP_EOL;
    }
} else {
    echo 'Validation passed';
}