<?php
namespace OpenAPI\Spec\V3\Traits;

use OpenAPI\Spec\Entities\Tag;

trait TagHandler
{
    private static function serializeTag(Tag $tag)
    {
        return $tag->extract();
    }
}
