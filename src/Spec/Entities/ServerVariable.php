<?php
namespace OpenAPI\Spec\Entities;

use JsonSerializable;
use Onion\Framework\Common\Hydrator\MethodHydrator;
use Onion\Framework\Hydrator\Interfaces\HydratableInterface;
use OpenAPI\Spec\Entities\Helpers\Describable;

class ServerVariable implements HydratableInterface
{
    private $default;
    private $enum = [];

    use Describable;
    use MethodHydrator;

    public function __construct($value)
    {
        $this->default = $value;
    }

    public function setEnum(array $enum)
    {
        $this->enum = $enum;
    }

    public function getEnum(): array
    {
        return $this->enum;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function addEnum($value)
    {
        $this->enum[] = $value;
    }
}
