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

    private static function parsePath(string $name, array $path): Path
    {
        /** @var Path $object */
        $object = (new Path($name))->hydrate($path);
        foreach ($path['parameters'] ?? [] as $parameter) {
            $object->addParameter(static::parseParameter($parameter));
        }

        $operations = array_filter($path, function ($key) {
            return !in_array($key, ['name', 'description', 'summary', 'parameters']);
        }, ARRAY_FILTER_USE_KEY);
        foreach ($operations as $name => $operation) {
            $object->addOperation(static::parseOperation($name, $operation));
        }

        return $object;
    }
}
