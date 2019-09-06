<?php
namespace OpenAPI\Spec\V3\Traits;

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

    private static function parseProperty(string $name, array $property): Property
    {
        $object = (new Property(
            $name,
            $property['type'],
            $property['format'] ?? $property['items']['type'] ?? $property['$ref'] ?? ''
        ))->hydrate($property);

        if (isset($property['example'])) {
            $object->addExample(static::parseExample($property['example']));
        }

        return $object;
    }
}
