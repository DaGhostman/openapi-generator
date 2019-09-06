<?php
namespace OpenAPI\Spec\V3\Traits;

use OpenAPI\Spec\Entities\Components\Parameter;

trait ParameterHandler
{
    private static function serializeParameter(Parameter $parameter): array
    {
        $result = $parameter->extract([
            'name', 'in', 'deprecated', 'allowEmptyValue', 'description'
        ]);

        if ($parameter->isRequired() || $parameter->getPlace() === 'path') {
            $result['required'] = true;
        }

        if ($parameter->hasType()) {
            $result['schema']['type'] = $parameter->getType();
        }

        if ($parameter->hasFormat()) {
            $result['schema']['format'] = $parameter->getFormat();
        }

        return (array) $result;
    }

    private static function parseParameter(array $parameter): Parameter
    {
        return (new Parameter(
            $parameter['name'],
            $parameter['allowEmptyValue'] ?? false,
            $parameter['deprecated'] ?? false)
        )->hydrate($parameter)
            ->hydrate($parameter['schema'] ?? []);
    }
}
