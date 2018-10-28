<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities\Helpers;


trait Named
{
    private $name;
    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return (string) $this->name;
    }

    public function hasName(): bool
    {
        return $this->name !== null && $this->name !== '';
    }
}
