<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities;

use OpenAPI\Spec\Entities\Components\Operation;
use OpenAPI\Spec\Entities\Helpers\Describable;
use OpenAPI\Spec\Entities\Helpers\Named;
use OpenAPI\Spec\Entities\Helpers\Parametrised;
use OpenAPI\Spec\Interfaces\Component;

class Path implements Component
{
    private $operations = [];

    use Named, Describable, Parametrised;

    public function __construct($path)
    {
        $this->setName($path);
    }

    public function addOperation(Operation $operation)
    {
        $this->operations[strtolower($operation->getName())] = $operation;
    }

    public function getOperations(): array
    {
        return (array) $this->operations;
    }

    public function toArray(): array
    {
        $result = [];
        if ($this->hasSummary()) {
            $result['summary'] = $this->getSummary();
        }

        if ($this->hasDescription()) {
            $result['description'] = $this->getDescription();
        }

        foreach ($this->getOperations() as $name => $operation) {
            $result[$name] = $operation->toArray();
        }
        return $result;
    }
}
