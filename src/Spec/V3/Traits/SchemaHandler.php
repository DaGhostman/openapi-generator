<?php
namespace OpenAPI\Spec\V3\Traits;

use OpenAPI\Spec\Entities\Components\Schema;

trait SchemaHandler
{
    use PropertyHandler;

    private static function serializeSchema(Schema $schema)
    {
        $result = $schema->extract(['type', 'properties']);
        if ($schema->hasFormat()) {
            unset($result['format']);
            $format = $schema->getFormat();

            $result[$this->getType() !== 'array' ? 'format' : 'items'] =
                stripos($format, '#') === 0 ? ['$ref' => $format] : $format;
        }

        if (isset($result['properties'])) {
            foreach ($result['properties'] as $index => $property) {
                $result['properties'][$index] = static::serializeProperty($property);
            }
        }

        return $result;
    }

    private static function parseSchema(string $name, array $schema): Schema
    {
        $object = (new Schema($name))->hydrate($schema);
        if (isset($schema['format']) || isset($schema['items'])) {
            $object->setFormat($schema['format'] ?? $schema['items']);
        }

        foreach ($schema['properties'] ?? [] as $name => $property) {
            $object->addProperty(static::parseProperty($name, $property));
        }

        return $object;
    }
}
