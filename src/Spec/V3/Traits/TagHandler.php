<?php
namespace OpenAPI\Spec\V3\Traits;

use OpenAPI\Spec\Entities\Tag;

trait TagHandler
{
    use ExternalDocsHandler;

    private static function serializeTag(Tag $tag)
    {
        $result = $tag->extract(['name', 'description']);
        if ($tag->hasExternalDocs()) {
            $result['externalDocs'] = static::serializeExternalDocs($tag->getExternalDocs());
        }
    }

    private static function parseTag(array $tag): Tag
    {
        if (isset($tag['externalDocs'])) {
            $tag['externalDocs'] = static::parseExternalDocs($tag['externalDocs']);
        }

        return (new Tag($tag['name']))->hydrate($tag);
    }
}
