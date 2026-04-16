<?php

return [
    new \ITransDocumentValidator\Rules\DocumentContentLengthRule(150),
    new \ITransDocumentValidator\Rules\MetaDataFieldsRule(['author', 'title']),
    new \ITransDocumentValidator\Rules\ProhibitedWordsRule(['iknowright', 'forbidden', 'kek']),
];