<?php declare(strict_types=1);
namespace OpenAPI\Spec\V3;

use OpenAPI\Interfaces\ParserInterface;
use OpenAPI\Interfaces\ReaderInterface;
use OpenAPI\Spec\Entities\Document;

class Parser implements ParserInterface
{
    use Traits\InfoHandler;
    use Traits\SchemaHandler;
    use Traits\SecurityHandler;
    use Traits\ServerHandler;
    use Traits\PathHandler;
    use Traits\TagHandler;
    use Traits\ExternalDocsHandler;

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
            static::parseInfo($raw['info'])
        );

        if (isset($raw['security'])) {
            foreach ($raw['security'] as $scheme => $value) {
                foreach ($value as $k => $v) {
                    $document->addSecurity($k, $v);
                }
            }
        }

        foreach ($raw['components']['schemas'] ?? [] as $name => $schema) {
            $document->addComponent(static::parseSchema($name, $schema));
        }

        foreach ($raw['components']['securitySchemes'] ?? [] as $name => $schema) {
            $document->addComponent(static::parseSecurity($name, $schema));
        }

        foreach ($raw['components']['responses'] ?? [] as $code => $response) {
            $document->addComponent(static::parseResponse((string) $code, $response));
        }

        foreach ($raw['servers'] ?? [] as $server) {
            $document->addServer(static::parseServer($server));
        }

        foreach ($raw['paths'] ?? [] as $uri => $path) {
           $document->addPath(static::parsePath($uri, $path));
        }

        foreach ($raw['tags'] ?? [] as $tag) {
            $document->addTag(static::parseTag($tag));
        }

        if(isset($raw['externalDocs'])) {
            $document->setExternalDoc(static::parseExternalDocs($raw['externalDocs']));
        }

        return $document;
    }
}
