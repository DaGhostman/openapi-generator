<?php
namespace OpenAPI\Spec\V3\Traits;

use OpenAPI\Spec\Entities\Path;

trait PathHandler
{
    use ParameterHandler;
    use OperationHandler;

    private static function serializePath(Path $path)
    {
        $result = $path->extract(['summary', 'description']);

        if ($path->hasParameters()) {
            $result['parameters'];
            foreach ($path->getParameters() as $parameter) {
                $result['parameters'][] = static::serializeParameter($parameter);
            }
        }

        foreach ($path->getOperations() as $name => $operation) {
            $result[$name] = static::serializeOperation($operation);
        }

        return $result;
    }
}
