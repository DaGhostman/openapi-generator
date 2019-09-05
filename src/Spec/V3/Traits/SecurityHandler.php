<?php
namespace OpenAPI\Spec\V3\Traits;

use OpenAPI\Spec\Entities\Security;

trait SecurityHandler
{
    private static function serializeSecurity(Security $security)
    {
        return $security->extract();
    }

    private static function parseSecurity($definition)
    {
        return (new Security())->hydrate($definition);
    }
}
