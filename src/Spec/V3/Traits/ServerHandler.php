<?php
namespace OpenAPI\Spec\V3\Traits;

use OpenAPI\Spec\Entities\Server;
use OpenAPI\Spec\Entities\ServerVariable;

trait ServerHandler
{
    use ServerVariableHandler;

    private static function serializeServer(Server $server): array
    {
        $result = $server->extract();
        if (isset($result['variables'])) {
            foreach ($result['variables'] as $index => $var) {
                $result['variables'][$index] = self::serializeServerVariable($var);
            }
        }

        return (array) $result;
    }

    private static function parseServer(array $definition): Server
    {
        if (isset($definition['variables'])) {
            foreach ($definition['variables'] as $index => $variable) {
                $definition['variables'][$index] = static::parseVariable($variable);
            }
        }

        return (new Server($definition['url']))->hydrate($definition);
    }
}
