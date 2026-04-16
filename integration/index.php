<?php

require_once __DIR__ . '/../vendor/autoload.php';

use ITransDocumentValidator\DocumentValidationResult;
use ITransDocumentValidator\Factory\DocumentValidatorFactory;
use ITransDocumentValidator\Integration\Context;
use ITransDocumentValidator\Integration\Document;

$delimiter = str_repeat('-', 100) . PHP_EOL;

$printResult = function (DocumentValidationResult $result) {
    if (!$result->isValid()) {
        foreach ($result->getErrorMessages() as $errorMessage) {
            echo $errorMessage . PHP_EOL;
        }
    } else {
        echo 'Validation passed';
    }
};

$context = new Context();
$context->setTenantId('test-tenant');

$factory = new DocumentValidatorFactory();
$validator = $factory->fromBelongsToTenant($context);

$document = new Document(
    'doc-123',
    'Content with some prohibited words: forbidden, kek, iknowright.',
    ['author' => 'John Doe']
);
$result = $validator->validate($document);
$printResult($result);

echo $delimiter;

$document = new Document(
    'doc-123',
    'Content with some prohibited words: forbidden, kek, iknowright.',
    ['foo' => 'John Doe']
);
$result = $validator->validate($document);
$printResult($result);

echo $delimiter;

$document = new Document(
    'doc-123',
    'Content without any prohibited words and with a valid author',
    ['title' => 'Valid Document Title', 'author' => 'John Doe']
);
$result = $validator->validate($document);
$printResult($result);
echo PHP_EOL;