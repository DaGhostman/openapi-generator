<?php
require_once __DIR__ . '/vendor/autoload.php';

$info = new \OpenAPI\Spec\Entities\Info();
$info->setTitle('Demo API');
$info->setVersion('1.0.0');
$info->setSummary('A demo API to be documented');
$info->setDescription('A very cool api that totally needs to be documented for others');
$document = new \OpenAPI\Spec\Entities\Document($info);

$routes = include_once __DIR__ . '/routes.demo.php';
$prop = new \OpenAPI\Spec\Entities\Components\Property('id', 'integer', 'int64');
$prop->addExample(new \OpenAPI\Spec\Entities\Components\Example(1));
$schema = new \OpenAPI\Spec\Entities\Components\Schema('ProductList');
$schema->setType('object');
$schema->addProperty($prop);
$document->addComponent($schema);

$notFoundSchema = new \OpenAPI\Spec\Entities\Components\Schema('Error');
$notFoundSchema->setType('object');
$notFoundSchema->addProperty(new \OpenAPI\Spec\Entities\Components\Property('message', 'string'));
$notFoundSchema->addProperty(new \OpenAPI\Spec\Entities\Components\Property('code', 'integer', 'int64'));
$notFoundSchema->addProperty(new \OpenAPI\Spec\Entities\Components\Property(
    'details',
    'array',
    'string'
));

$response = new \OpenAPI\Spec\Entities\Components\Response('NotFound');
$response->setDescription('Not Found Page');
$response->addContent('application/json', new \OpenAPI\Spec\Entities\Components\MediaType(
    new \OpenAPI\Spec\Entities\Components\ReferenceObject('#/components/schemas/Error')
));

$createdResponse = new \OpenAPI\Spec\Entities\Components\Response('Created');
$createdResponse->setDescription('Object Successfully created');
$linkHeader = new \OpenAPI\Spec\Entities\Components\Header('Link');
$linkHeader->setDescription('The location of the newly created resource');
$linkHeader->setType('string');
$createdResponse->addHeader($linkHeader);
$document->addComponent($response);
$document->addComponent($createdResponse);
$document->addComponent($notFoundSchema);

foreach ($routes as $route) {
    $path = new \OpenAPI\Spec\Entities\Path($route['pattern']);

    foreach ($route['methods'] as $method) {
        // @todo: Make HTTP request to the endpoint
        $operation = new \OpenAPI\Spec\Entities\Components\Operation(strtolower($method), $route['deprecated'] ?? false);

        $path->addOperation($operation);
    }

    $document->addPath($path);
}

$generator = new \OpenAPI\Spec\V3\Serializer($document);

file_put_contents(__DIR__ . '/swagger.json', $generator->serialize());
