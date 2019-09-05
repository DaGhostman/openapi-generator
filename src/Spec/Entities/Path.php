<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities;

use Onion\Framework\Common\Hydrator\MethodHydrator;
use OpenAPI\Spec\Entities\Components\Operation;
use OpenAPI\Spec\Entities\Helpers\Describable;
use OpenAPI\Spec\Entities\Helpers\Named;
use OpenAPI\Spec\Entities\Helpers\Parametrised;
use OpenAPI\Spec\Interfaces\Component;

class Path implements Component
{
    private $operations = [];

    use Named, Describable, Parametrised;
    use MethodHydrator;

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
}
