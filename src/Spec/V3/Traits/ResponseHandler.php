<?php
namespace OpenAPI\Spec\V3\Traits;

use OpenAPI\Spec\Entities\Components\Header;
use OpenAPI\Spec\Entities\Components\ReferenceObject;
use OpenAPI\Spec\Entities\Components\Response;

trait ResponseHandler
{
    use HeaderHandler;
    use ReferenceObjectHandler;
    use MediaTypeHandler;

    private static function serializeResponse(Response $response): array
    {
        $result = $response->extract();
        if (isset($result['headers'])) {
            foreach ($result['headers'] as $name => $header) {
                if ($header instanceof ReferenceObject) {
                    $result['headers'][$name] = static::serializeReferenceObject($header);
                }

                if ($header instanceof Header) {
                    $result['headers'][$name] = static::serializeHeader($header);
                }
            }
        }

        if (isset($result['content'])) {
            foreach ($result['content'] as $index => $mediaType) {
                $result['content'][$index] = static::serializeMediaType($mediaType);
            }
        }

        return $result;
    }
}
