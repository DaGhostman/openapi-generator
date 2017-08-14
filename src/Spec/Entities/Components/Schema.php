<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities\Components;

use OpenAPI\Spec\Entities\Helpers\Formatted;
use OpenAPI\Spec\Entities\Helpers\Named;
use OpenAPI\Spec\Interfaces\Component;

class Schema implements Component
{
    private $properties = [];

    use Named, Formatted;

    public function __construct(string $name)
    {
        $this->setName($name);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function addProperty(Component $property)
    {
        if (!$property instanceof Property && !$property instanceof ReferenceObject) {
            throw new \InvalidArgumentException('Invalid Property');
        }

        $this->properties[$property->getName()] = $property;
    }

    public function toArray(): array
    {
        $result = [
            'type' => $this->getType(),
        ];

        if ($this->hasFormat()) {
            $result[$this->getType() !== 'array' ? 'format' : 'items'] = $this->getFormat();
        }

        foreach ($this->getProperties() as $property) {
            /** @var Property $property */
            $result['properties'][$property->getName()] = $property->toArray();
        }

        return $result;
    }
}