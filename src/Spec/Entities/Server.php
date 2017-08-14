<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities;

use OpenAPI\Spec\Entities\Helpers\Describable;

class Server
{
    private $url;
    private $variables = [];

    use Describable;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getVariables(): array
    {
        return $this->variables;
    }

    public function addVariable(string $name, ServerVariable $value)
    {
        $this->variables[$name] = $value;
    }

    public function getUrl(): string
    {
        return (string) $this->url;
    }
}