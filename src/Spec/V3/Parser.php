<?php declare(strict_types=1);
namespace OpenAPI\Spec\V3;

use OpenAPI\Interfaces\ParserInterface;
use OpenAPI\Interfaces\ReaderInterface;
use OpenAPI\Spec\Entities\Document;
use OpenAPI\Spec\Entities\Info;
use OpenAPI\Spec\Entities\Information\License;
use OpenAPI\Spec\Entities\Information\Contact;
use OpenAPI\Spec\Entities\Path;
use OpenAPI\Spec\Entities\Components\Param;
use OpenAPI\Spec\Entities\Components\Operation;
use OpenAPI\Spec\Entities\Components\ReferenceObject;
use OpenAPI\Spec\Entities\Components\Response;
use OpenAPI\Spec\Entities\Components\MediaType;
use OpenAPI\Spec\Entities\Components\Schema;

class Parser implements ParserInterface
{
    private const HTTP_METHODS = ['GET', 'HEAD', 'PUT', 'POST', 'PATCH', 'DELETE', 'OPTIONS', 'TRACE'];
    /** @var ReaderInterface $reader */
    private $reader;

    public function __construct(ReaderInterface $reader)
    {
        $this->reader = $reader;
    }

    public function parse(string $file): Document
    {
        $raw = $this->reader->parseFile($file);
        $document = new Document(
            $this->handleInfo($raw['info'])
        );

        foreach ($raw['components']['schemas'] ?? [] as $name => $schema) {
            $document->addComponent($this->handleSchema($name, $schema));
        }

        foreach ($raw['paths'] ?? [] as $uri => $path) {
           $document->addPath($this->handlePath($document, $uri, $path));
        }

        return $document;
    }

    private function handleInfo(array $info)
    {
        $object = new Info();

        if (isset($info['summary'])) {
            $object->setSummary($info['summary']);
        }

        if (isset($info['termsOfService'])) {
            $object->setTermsUrl($info['termsOfService']);
        }

        if (isset($info['license'])) {
            $object->setLicense($this->handleLicense($info['license']));
        }

        if (isset($info['version'])) {
            $object->setVersion($info['version']);
        }

        if (isset($info['title'])) {
            $object->setTitle($info['title']);
        }

        if (isset($info['description'])) {
            $object->setDescription($info['description']);
        }

        return $object;
    }

    private function handleLicense(array $license): License
    {
        $object = new License($license['name']);
        if (isset($license['url'])) {
            $object->setUrl($license['url']);
        }

        return $object;
    }

    private function handleContact(array $contact): Contact
    {
        $object = new Contact();

        if (isset($contact['name'])) {
            $object->setName($contact['name']);
        }

        if (isset($contact['email'])) {
            $object->setEmail($contact['email']);
        }

        if (isset($contact['url'])) {
            $object->setUrl($contact['url']);
        }

        return $object;
    }

    private function handleSchema(string $name, array $schema)
    {
        $object = new Schema($name);
        $object->setType($schema['type']);
        foreach ($schema['properties'] as $property) {
            $object->addProperty($this->handleProperty($property));
        }
    }

    private function handlePath(Document $document, string $uri, array $path)
    {
        $object = new Path($uri);
        if (isset($path['description'])) {
            $object->setDescription($path['description']);
        }

        if (isset($path['summary'])) {
            $object->setSummary($path['summary']);
        }

        if (isset($path['parameters'])) {
            foreach ($path['parameters'] as $parameter) {
                $object->addParameter(
                    $this->handleParam($parameter)
                );
            }
        }

        foreach ($path as $key => $value) {
            if (!in_array($key, self::HTTP_METHODS)) {
                continue;
            }

            $object->addOperation(
                $this->handleOperation($document, $key, $operation)
            );
        }

        return $object;
    }

    private function handleOperation(Document $document, string $method, array $operation)
    {
        $object = new Operation($method, $operation['deprecated'] ?? false);

        foreach ($operation['responses'] as $status => $response) {
            if (isset($response['$ref'])) {
                $r = new ReferenceObject($response['$ref']);
            }

            if (!isset($response['$ref'])) {
                $r = new Response($status);
                if (isset($response['description'])) {
                    $r->setDescription($response['description']);
                }

                if (isset($response['summary'])) {
                    $r->setSummary($response['summary']);
                }

                foreach ($response['content'] as $type => $body) {
                    $r->addContent(
                        $type,
                        new MediaType(
                            new ReferenceObject($body['$ref'])
                        )
                    );
                }
            }

            $object->addResponse($status, $r);
        }

        return $object;
    }

    private function handleParam(array $parameter): Param
    {
        $param = new Param(
            $parameter['name'],
            $parameter['allowEmptyValue'] ?? false,
            $parameter['required'] ?? false
        );

        $param->setType($parameter['type']);
        $param->setPlace($parameter['in']);
        if (isset($parameter['deprecated'])) {
            $param->setDeprecated($parameter['deprecated']);
        }
        if (isset($parameter['summary'])) {
            $param->setSummary($parameter['summary']);
        }
        $param->setFormat($parameter['format'] ?? '');
        if (isset($parameter['description'])) {
            $param->setDescription($parameter['description']);
        }

        return $param;
    }
}
