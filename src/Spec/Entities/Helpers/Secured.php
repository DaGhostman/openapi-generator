<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities\Helpers;

trait Secured
{
    private $name;
    private $scopes = [];

    public function setScheme(string $name)
    {
        $this->name = $name;
    }

    public function getScheme(): string
    {
        return (string) $this->name;
    }

    public function hasScheme(): bool
    {
        return $this->name !== null && $this->name !== '';
    }

    public function setScopes(string $scopes): string
    {
        return $this->scopes = $scopes;
    }

    public function getScopes()
    {
        return $this->scopes;
    }
}
