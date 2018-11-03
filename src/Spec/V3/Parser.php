<?php declare(strict_types=1);
namespace OpenAPI\Spec\V3;

use OpenAPI\Interfaces\ParserInterface;
use OpenAPI\Interfaces\ReaderInterface;
use OpenAPI\Spec\Entities\Components\Example;
use OpenAPI\Spec\Entities\Components\Header;
use OpenAPI\Spec\Entities\Components\MediaType;
use OpenAPI\Spec\Entities\Components\Operation;
use OpenAPI\Spec\Entities\Components\Param;
use OpenAPI\Spec\Entities\Components\Property;
use OpenAPI\Spec\Entities\Components\ReferenceObject;
use OpenAPI\Spec\Entities\Components\Response;
use OpenAPI\Spec\Entities\Components\Schema;
use OpenAPI\Spec\Entities\Document;
use OpenAPI\Spec\Entities\Info;
use OpenAPI\Spec\Entities\Information\Contact;
use OpenAPI\Spec\Entities\Information\License;
use OpenAPI\Spec\Entities\Path;
use OpenAPI\Spec\Entities\Server;
use OpenAPI\Spec\Entities\ServerVariable;
use OpenAPI\Spec\Entities\Tag;
use OpenAPI\Spec\Entities\Components\ExternalDoc;

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

        if (isset($raw['security'])) {
            foreach ($raw['security'] as $scheme => $value) {
                $document->addSecurity($scheme, $value);
            }
        }

        foreach ($raw['components']['schemas'] ?? [] as $name => $schema) {
            $document->addComponent($this->handleSchema($name, $schema));
        }

        foreach ($raw['servers'] ?? [] as $server) {
            $document->addServer($this->handleServer($server));
        }

        foreach ($raw['paths'] ?? [] as $uri => $path) {
           $document->addPath($this->handlePath($document, $uri, $path));
        }

        foreach ($raw['tags'] ?? [] as $tag) {
            $t = new Tag($tag['name']);
            $t->setDescription($tag['description'] ?? '');
            if (isset($tag['externalDocs'])) {
                $doc = new ExternalDoc($tag['externalDocs']['url']);
                $doc->setDescription($tag['externalDocs'][''] ?? '');
                $t->setExternalDoc($doc);
            }

            $document->addTag($t);
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

        if (isset($info['contact'])) {
            $contact = new Contact();
            if (isset($info['contact']['name'])) {
                $contact->setName($info['contact']['name']);
            }

            if (isset($info['contact']['email'])) {
                $contact->setEmail($info['contact']['email']);
            }

            if (isset($info['contact']['url'])) {
                $contact->setUrl($info['contact']['url']);
            }

            $object->setContact($contact);
        }

        return $object;
    }

    private function handleLicense(array $license): License
    {
        $object = new License($license['name']);
        $object->setUrl($license['url'] ?? '');

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
        $object->setType($schema['type'] ?? (isset($schema['properties']) ? 'object' : ''));
        foreach ($schema['properties'] ?? [] as $name => $property) {
            $object->addProperty($this->handleProperty($name, $property));
        }

        if (isset($schema['items'])) {
            $object->setFormat($schema['items']['type'] ?? $schema['items']['$ref']);
        }

        if (isset($schema['required'])) {
            $object->setRequired($schema['required']);
        }

        return $object;
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

        foreach ($path as $key => $operation) {
            if (!in_array(strtoupper($key), self::HTTP_METHODS)) {
                continue;
            }

            $object->addOperation(
                $this->handleOperation($key, $operation)
            );
        }

        return $object;
    }

    private function handleOperation(string $method, array $operation)
    {
        $object = new Operation($method, $operation['deprecated'] ?? false);
        if (isset($operation['operationId'])) {
            $object->setOperationId($operation['operationId']);
        }

        if (isset($operation['summary'])) {
            $object->setSummary($operation['summary']);
        }

        if (isset($operation['description'])) {
            $object->setDescription($operation['description']);
        }

        if (isset($operation['tags'])) {
            foreach ($operation['tags'] as $tag) {
                $object->addTag($tag);
            }
        }

        if (isset($operation['parameters'])) {
            foreach ($operation['parameters'] as $param) {
                $object->addParameter(
                    $this->handleParam($param)
                );
            }
        }

        foreach ($operation['responses'] as $status => $response) {
            if (isset($response['$ref'])) {
                $r = new ReferenceObject($response['$ref']);
            }

            if (!isset($response['$ref'])) {
                $r = new Response("{$status}");
                if (isset($response['description'])) {
                    $r->setDescription($response['description']);
                }

                if (isset($response['summary'])) {
                    $r->setSummary($response['summary']);
                }

                if (isset($response['headers'])) {
                    foreach ($response['headers'] as $name => $header) {
                        $h = new Header($name);
                        $h->setDescription($header['description'] ?? '');
                        $h->setType($header['schema']['type'] ?? '');
                        $h->setFormat($header['schema']['format'] ?? '');
                        $r->addHeader($h);
                    }
                }

                foreach ($response['content'] ?? [] as $type => $body) {
                    $r->addContent(
                        $type,
                        new MediaType(
                            new ReferenceObject($body['schema']['$ref'] ?? $body['$ref'])
                        )
                    );
                }
            }

            $object->addResponse("{$status}", $r);
        }

        return $object;
    }

    private function handleParam(array $parameter): Param
    {
        $param = new Param(
            $parameter['name'],
            $parameter['allowEmptyValue'] ?? false,
            $parameter['deprecated'] ?? false
        );

        $param->setRequired($parameter['required'] ?? false);

        if (isset($parameter['schema']['type'])) {
            $param->setType($parameter['schema']['type']);
        }

        if (isset($parameter['schema']['format'])) {
            $param->setFormat($parameter['schema']['format']);
        }

        $param->setPlace($parameter['in']);
        $param->setDeprecated($parameter['deprecated'] ?? false);
        $param->setSummary($parameter['summary'] ?? '');
        $param->setDescription($parameter['description'] ?? '');

        return $param;
    }

    private function handleProperty($name, $property)
    {
        $prop = new Property($name, $property['type'], $property['format'] ?? '');
        if ($prop->getType() === 'array') {
            $prop->setFormat($property['items']['type']);
        }

        if (isset($property['example'])) {
            $prop->addExample(new Example($property['example']));
        }

        if (isset($property['enum'])) {
            $prop->setValues($property['enum']);
        }

        return $prop;
    }

    private function handleServer($server)
    {
        $srv = new Server($server['url']);
        if (isset($server['description'])) {
            $srv->setDescription($server['description']);
        }

        if (isset($server['variables'])) {
            foreach ($server['variables'] as $name => $var) {
                $srv->addVariable($name, $this->handleServerVariable($var));
            }
        }

        return $srv;
    }

    private function handleServerVariable(array $variable)
    {
        $var = new ServerVariable($variable['default'] ?? null);

        if (isset($variable['enum'])) {
            $var->setEnum($variable['enum']);
        }

        if (isset($variable['description'])) {
            $var->setDescription($variable['description']);
        }

        return $var;
    }

    private function handleResponse(string $name, array $response)
    {
        $resp = '';
    }
}
