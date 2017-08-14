<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities;

class Security
{
    private $name;
    private $values;
    public function __construct(string $name, array $values = [])
    {
        $this->name = $name;
        $this->values = $values;
    }

    public function getName(): string
    {
        return (string) $this->name;
    }

    public function getValues(): array
    {
        return (array) $this->values;
    }

    public function hasValues(): bool
    {
        return !empty($this->values);
    }
}