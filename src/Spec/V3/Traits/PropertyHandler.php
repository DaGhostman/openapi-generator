<?php
namespace OpenAPI\Spec\V3\Traits;

use OpenAPI\Spec\Entities\Components\Example;
use OpenAPI\Spec\Entities\Components\Property;

trait PropertyHandler
{
    use ExampleHandler;

    private static function serializeProperty(Property $property)
    {
        $result = $property->extract(['type', 'enum']);

        if ($property->getType() === 'array') {
            $result['items'] = [
                (stripos($property->getFormat(), '#') === 0 ? '$ref' : 'type') => $property->getFormat()
            ];
        } else {
            if ($property->hasFormat()) {
                $result[(stripos($property->getFormat(), '#') === 0 ? '$ref' : 'format')] = $property->getFormat();
            }
        }

        if ($property->hasExamples()) {
            $result['example'] = current($property->getExamples())->getValue();
        }

        return $result;
    }
}
