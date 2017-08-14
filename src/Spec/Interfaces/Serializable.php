<?php declare(strict_types=1);
namespace OpenAPI\Spec\Interfaces;

interface Serializable
{
    public function toArray(): array;
}
