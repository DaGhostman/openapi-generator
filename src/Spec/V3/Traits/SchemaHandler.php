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
}
