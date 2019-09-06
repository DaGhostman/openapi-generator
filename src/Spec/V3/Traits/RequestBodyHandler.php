<?php
namespace OpenAPI\Spec\V3\Traits;

use OpenAPI\Spec\Entities\Components\RequestBody;

trait RequestBodyHandler
{
    use MediaTypeHandler;

    private static function serializeRequestBody(RequestBody $requestBody)
    {
        $result = ['content' => []];
        foreach ($requestBody->getContent() as $type => $mime) {
            $result['content'][$type] = static::serializeMediaType($mime);
        }

    }
}
