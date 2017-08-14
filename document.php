<?php
require_once __DIR__ . '/vendor/autoload.php';

$info = new \OpenAPI\Spec\Entities\Info();
$document = new \OpenAPI\Spec\Entities\Document($info);

if (file_exists(getcwd() . '/openapi.document.php')) {
    include getcwd() . '/openapi.document.php';
}

if (file_exists(getcwd() . '/composer.json')) {
    $composer = json_decode(file_get_contents(getcwd() . '/composer.json'), true);
    if (!$document->getInfo()->hasDescription() && isset($composer['description'])) {
        $document->getInfo()->setDescription($composer['description']);
    }

    if (!$document->getInfo()->hasLicense() && isset($composer['license'])) {
        $document->getInfo()->setLicense(
            new \OpenAPI\Spec\Entities\Information\License($composer['license'])
        );
    }

    if (!$document->getInfo()->hasContact() && isset($composer['authors'])) {
        $author = new \OpenAPI\Spec\Entities\Information\Contact();
        $author->setName($composer['authors'][0]['name']);
        $author->setEmail($composer['authors'][0]['email']);

        if (isset($composer['support']) && isset($composer['support']['email'])) {
            $author->setEmail($composer['support']['email']);
        }

        $document->getInfo()->setContact($author);
    }

    if (isset($composer['support']) && isset($composer['support']['docs'])) {
        $docs = new \OpenAPI\Spec\Entities\Components\ExternalDoc(
            $composer['support']['docs']
        );
        $document->setExternalDoc($docs);
    }
}

try {
    $document->getInfo()->getVersion();
} catch (\TypeError $ex) {
    $document->getInfo()->setVersion('1.0.0');
}


$serializer = new \OpenAPI\Spec\V3\Serializer($document);
file_put_contents(
    getcwd() . '/swagger.json',
    json_encode($serializer->serialize(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
);

