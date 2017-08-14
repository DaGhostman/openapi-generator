<?php
/**
 * @var \OpenAPI\Spec\Entities\Document $document
 */

$document->getInfo()->setTitle('My Awesome API');

$notFoundSchema = new \OpenAPI\Spec\Entities\Components\Schema('Error');
$notFoundSchema->setType('object');
$message = new \OpenAPI\Spec\Entities\Components\Property('message', 'string');
$message->addExample(new \OpenAPI\Spec\Entities\Components\Example('Fatal Error'));
$notFoundSchema->addProperty($message);
$code = new \OpenAPI\Spec\Entities\Components\Property('code', 'integer', 'int64');
$code->addExample(new \OpenAPI\Spec\Entities\Components\Example(123456));
$notFoundSchema->addProperty($code);
$details = new \OpenAPI\Spec\Entities\Components\Property(
    'details',
    'array',
    'string'
);
$details->addExample(new \OpenAPI\Spec\Entities\Components\Example(['Invalid page number', 'Offset out of bounds']));
$notFoundSchema->addProperty($details);
$document->addComponent($notFoundSchema);

$notFoundResponse = new \OpenAPI\Spec\Entities\Components\Response('NotFound');
$notFoundResponse->setDescription('Not Found Page');
$notFoundResponse->addContent('application/json', new \OpenAPI\Spec\Entities\Components\MediaType(
    new \OpenAPI\Spec\Entities\Components\ReferenceObject('#/components/schemas/Error')
));
$document->addComponent($notFoundResponse);

$createdResponse = new \OpenAPI\Spec\Entities\Components\Response('Created');
$createdResponse->setDescription('Object Successfully created');
$linkHeader = new \OpenAPI\Spec\Entities\Components\Header('Link');
$linkHeader->setDescription('The location of the newly created resource');
$linkHeader->setType('string');
$createdResponse->addHeader($linkHeader);

$server = new \OpenAPI\Spec\Entities\Server('https://localhost/');
$server->setDescription('The API server');
$document->addServer($server);