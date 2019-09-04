<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities;

use JsonSerializable;
use OpenAPI\Spec\Entities\Helpers\Describable;

class Server implements JsonSerializable
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

    public function jsonSerialize()
    {
        $result = [
            'url' => $this->getUrl(),
        ];

        if ($this->hasDescription()) {
            $result['description'] = $this->getDescription();
        }

        if ($this->getVariables() !== []) {
            $result['variables'] = $this->getVariables();
        }

        return $result;
    }
}
