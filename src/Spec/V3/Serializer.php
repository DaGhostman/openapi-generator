<?php declare(strict_types=1);
namespace OpenAPI\Spec\V3;

use OpenAPI\Spec\Entities\Components\RequestBody;
use OpenAPI\Spec\Entities\Components\Response;
use OpenAPI\Spec\Entities\Components\Schema;
use OpenAPI\Spec\Entities\Document;
use OpenAPI\Spec\Entities\Path;
use OpenAPI\Spec\Entities\Tag;

class Serializer
{
    use Traits\ServerHandler;
    use Traits\InfoHandler;
    use Traits\SecurityHandler;
    use Traits\PathHandler;
    use Traits\ResponseHandler;
    use Traits\RequestBodyHandler;
    use Traits\SchemaHandler;
    use Traits\TagHandler;
    use Traits\ExternalDocsHandler;

    public static function serialize(Document $document): array
    {
        $result = [
            'openapi' => '3.0.0',
            'info' => static::serializeInfo($document->getInfo()),
        ];

        if ($document->getServers() !== []) {
            $result['servers'] = [];
            foreach ($document->getServers() as $server) {
                $result['servers'][] = static::serializeServer($server);
            }
        }

        foreach ($document->getPaths() as $name => $path) {
            /** @var Path $path */
            $result['paths'][$name] = static::serializePath($path);

        }

        foreach ($document->getComponents() as $type => $components) {
            foreach ($components as $name => $component) {
                if ($component instanceof Response) {
                    $result['components'][$type][$name] = static::serializeResponse($component);
                }

                if ($component instanceof Schema) {
                    $result['components'][$type][$name] = static::serializeSchema($component);
                }

                if ($component instanceof RequestBody) {
                    $result['components'][$type][$name] = static::serializeRequestBody($component);
                }
            }
        }

        if ($document->hasSecurity()) {
            $result['security'] = [static::serializeSecurity($document->getSecurity())];
        }

        foreach ($document->getTags() as $tag) {
            /** @var Tag $tag */
            $result['tags'][] = static::serializeTag($tag);
        }

        if ($document->hasExternalDocs()) {
            $result['externalDocs'] = static::serializeExternalDocs($document->getExternalDocs());
        }

        return $result;
    }
}
