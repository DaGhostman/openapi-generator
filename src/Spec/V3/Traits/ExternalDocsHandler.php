<?php
namespace OpenAPI\Spec\V3\Traits;

use OpenAPI\Spec\Entities\Components\ExternalDoc;

trait ExternalDocsHandler
{
    private static function serializeExternalDocs(ExternalDoc $externalDoc)
    {
        $result = $externalDoc->extract(['description']);
        $result['url'] = $externalDoc->getName();

        return $result;
    }
}
