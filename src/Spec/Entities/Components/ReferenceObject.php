<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities\Components;

use OpenAPI\Spec\Interfaces\Component;

class ReferenceObject implements Component
{
    private $ref;
    public function __construct(string $ref)
    {
        $this->ref = $ref;
    }

    public function getRef(): string
    {
        return (string) $this->ref;
    }

    public function toArray(): array
    {
        return [
            '$ref' => $this->getRef()
        ];
    }
}