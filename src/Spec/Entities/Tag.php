<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities;

use OpenAPI\Spec\Entities\Helpers\Describable;
use OpenAPI\Spec\Entities\Helpers\Documentable;
use OpenAPI\Spec\Interfaces\Component;

class Tag implements Component
{
    private $name;

    use Describable, Documentable;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return (string) $this->name;
    }

    public function toArray(): array
    {
        $result = [
            'name' => $this->getName()
        ];

        if ($this->hasDescription()) {
            $result['description'] = $this->getDescription();
        }

        if ($this->hasExternalDoc()) {
            $result['externalDocs'] = $this->getExternalDoc()->toArray();
        }

        return $result;
    }
}