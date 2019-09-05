<?php
namespace OpenAPI\Spec\V3\Traits;

use OpenAPI\Spec\Entities\Components\ReferenceObject;

trait ReferenceObjectHandler
{
    private static function serializeReferenceObject(ReferenceObject $ref)
    {
        return ['$ref' => $ref->getRef()];
    }
}
