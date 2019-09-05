<?php
namespace OpenAPI\Spec\V3\Traits;

use OpenAPI\Spec\Entities\ServerVariable;

trait ServerVariableHandler
{
    private static function serializeServerVariable(ServerVariable $variable)
    {
        return $variable->extract();
    }

    private static function parseVariable(array $variable)
    {
        return (new ServerVariable($variable['default'] ?? ''))->hydrate($variable);
    }
}
