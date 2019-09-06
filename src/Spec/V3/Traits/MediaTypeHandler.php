<?php
namespace OpenAPI\Spec\V3\Traits;

use OpenAPI\Spec\Entities\Components\MediaType;

trait MediaTypeHandler
{
    use ReferenceObjectHandler;

    private static function serializeMediaType(MediaType $media)
    {
        return [
            'schema' => static::serializeReferenceObject($media->getReferenceObject()),
        ];
    }

    private static function parseMediaType(array $mediaType): MediaType
    {
        return (new MediaType(static::parseReferenceObject($mediaType['schema'])));
    }
}
