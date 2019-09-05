<?php
namespace OpenAPI\Spec\V3\Traits;

use OpenAPI\Spec\Entities\Info;
use OpenAPI\Spec\Entities\Information\Contact;
use OpenAPI\Spec\Entities\Information\License;

trait InfoHandler
{
    use ContactHandler, LicenseHandler;

    private static function serializeInfo(Info $info)
    {
        $result = $info->extract();
        if (isset($result['license'])) {
            $result['license'] = static::serializeLicense($result['license']);
        }

        if (isset($result['contact'])) {
            $result['contact'] = static::serializeContact($result['contact']);
        }

        return $result;
    }

    private static function parseInfo(array $info): Info
    {
        if (isset($info['contact'])) {
            $info['contact'] = (new Contact)->hydrate($info['contact']);
        }

        if (isset($info['license'])) {
            $info['license'] = (new License($info['license']['name'] ?? ''))->hydrate($info['license']);
        }

        return (new Info)->hydrate($info);
    }
}
