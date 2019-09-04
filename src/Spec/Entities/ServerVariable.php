<?php
namespace OpenAPI\Spec\Entities;

use JsonSerializable;
use OpenAPI\Spec\Entities\Helpers\Describable;

class ServerVariable implements JsonSerializable
{
    private $default;
    /**
     * @var string[]
     */
    private $enum = [];

    use Describable;

    public function __construct(string $value)
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

    public function addEnum(string $value)
    {
        $this->enum[] = $value;
    }

    public function jsonSerialize()
    {
        $result = ['default' => $this->default];

        if ($this->enum !== []) {
            $result['enum'] = $this->enum;
        }

        return $result;
    }
}
