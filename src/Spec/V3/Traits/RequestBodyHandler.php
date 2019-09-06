<?php
namespace OpenAPI\Spec\V3\Traits;

use OpenAPI\Spec\Entities\Components\RequestBody;

trait RequestBodyHandler
{
    use MediaTypeHandler;

    private static function serializeRequestBody(RequestBody $requestBody): array
    {
        $result = ['content' => []];
        foreach ($requestBody->getContent() as $type => $mime) {
            $result['content'][$type] = static::serializeMediaType($mime);
        }

        return $result;
    }

    private static function parseRequestBody(array $requestBody): RequestBody
    {
        $object = new RequestBody('??');
        foreach ($requestBody as $type => $body) {
            $object->addContent($type, static::parseMediaType($body));
        }

        return $object;
    }
}
