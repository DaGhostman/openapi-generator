<?php

use OpenAPI\Spec\Entities\Components\Example;
use OpenAPI\Spec\Entities\Components\MediaType;
use OpenAPI\Spec\Entities\Components\ReferenceObject;
use OpenAPI\Spec\Entities\Server;
use OpenAPI\Spec\Entities\ServerVariable;

require_once __DIR__ . '/vendor/autoload.php';

$info = new \OpenAPI\Spec\Entities\Info();
$info->setTitle('Demo API');
$info->setVersion('1.0.0');
$info->setSummary('A demo API to be documented');
$info->setDescription('A very cool api that totally needs to be documented for others');
$info->setContact((new \OpenAPI\Spec\Entities\Information\Contact)->hydrate(['name' => 'me', 'url' => 'https://example.com']));
$document = new \OpenAPI\Spec\Entities\Document($info);

$routes = include_once __DIR__ . '/routes.demo.php';
$prop = new \OpenAPI\Spec\Entities\Components\Property('id', 'integer', 'int64');
$prop->addExample(new \OpenAPI\Spec\Entities\Components\Example(1, false, 'single'));
$prop->addExample(new \OpenAPI\Spec\Entities\Components\Example('1, 5', false, 'multi'));
$schema = new \OpenAPI\Spec\Entities\Components\Schema('ProductList');
$schema->setType('object');
$schema->addProperty($prop);
$document->addComponent($schema);

$productSchema = new \OpenAPI\Spec\Entities\Components\Schema('Product');
$id = new \OpenAPI\Spec\Entities\Components\Property('id', 'number', 'int64');
$id->addExample(new Example(1));
$productSchema->addProperty($id);
$name = new \OpenAPI\Spec\Entities\Components\Property('name', 'string');
$name->addExample(new Example('Product #1'));
$productSchema->addProperty($name);
$document->addComponent($productSchema);

$requestBody = new \OpenAPI\Spec\Entities\Components\RequestBody('product', true);
$requestBody->addContent(
    'product', new MediaType(
        new ReferenceObject('#/components/schemas/Product')
    )
);

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

$productResponse = new \OpenAPI\Spec\Entities\Components\Response('Product');
$productResponse->addContent('application/json', new MediaType(
    new ReferenceObject('#/components/schemas/Product')
));
$productResponse->setDescription('Returns a single product');
$document->addComponent($productResponse);

$linkHeader = new \OpenAPI\Spec\Entities\Components\Header('Link');
$linkHeader->setDescription('The location of the newly created resource');
$linkHeader->setType('string');
$createdResponse->addHeader($linkHeader);
$createdResponse->addContent('application/json', new MediaType(
    new ReferenceObject('#/components/schemas/ProductList')
));
$document->addComponent($response);
$document->addComponent($createdResponse);
$document->addComponent($notFoundSchema);
$server = new Server('https://example.com');
$server->addVariable('foo', new ServerVariable('bar'));
$document->addServer($server);

foreach ($routes as $route) {
    $path = new \OpenAPI\Spec\Entities\Path($route['pattern']);

    foreach ($route['methods'] as $method) {
        // @todo: Make HTTP request to the endpoint
        $operation = new \OpenAPI\Spec\Entities\Components\Operation(strtolower($method), $route['deprecated'] ?? false);
        if (strtolower($method) === 'post') {
            $operation->setRequestBody(new ReferenceObject('#/components/requestBodies/Product'));
            $operation->addResponse('201', new ReferenceObject('#/components/responses/Created'));
        } else {
            $operation->addResponse('200', new ReferenceObject('#/components/responses/Product'));
        }
        $operation->addResponse('404', new ReferenceObject('#/components/responses/NotFound'));

        $path->addOperation($operation);
    }

    $document->addPath($path);
}

file_put_contents(__DIR__ . '/swagger.json', json_encode(\OpenAPI\Spec\V3\Serializer::serialize($document), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
