<?php
namespace OpenAPI\Spec\V3\Traits;

use OpenAPI\Spec\Entities\Information\License;

trait LicenseHandler
{
    private static function serializeLicense(License $license)
    {
        return $license->extract();
    }

    private static function parseLicense(array $data): License
    {
        return (new License($data['name'] ?? ''))->hydrate($data);
    }
}
