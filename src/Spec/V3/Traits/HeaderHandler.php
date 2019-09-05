<?php
namespace OpenAPI\Spec\V3\Traits;

use OpenAPI\Spec\Entities\Components\Header;

trait HeaderHandler
{
    private static function serializeHeader(Header $header)
    {
        $result = $header->extract([
            'deprecated',
            'allowEmptyValue',
            'required',
            'description',
        ], Header::EXCLUDE_EMPTY | Header::USE_RAW_KEYS);

        $result['schema']['type'] = $header->getType();
        if ($header->hasFormat()) {
            $result['schema']['format'] = $header->getFormat();
        }

        return $result;
    }
}
