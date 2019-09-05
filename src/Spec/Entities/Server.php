<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities;

use Onion\Framework\Common\Hydrator\MethodHydrator;
use Onion\Framework\Hydrator\Interfaces\HydratableInterface;
use OpenAPI\Spec\Entities\Helpers\Describable;

class Server implements HydratableInterface
{
    private $url;
    private $variables = [];

    use Describable;
    use MethodHydrator;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getVariables(): array
    {
        return $this->variables;
    }

    public function setVariables(array $variables)
    {
        $this->variables = $variables;
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
