<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities\Helpers;

trait Typed
{
    private $type;
    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return (string) $this->type;
    }

    public function hasType(): bool
    {
        return $this->type !== null;
    }
}