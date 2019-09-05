<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities\Helpers;

use OpenAPI\Spec\Entities\Components\Parameter;

trait Parametrised
{
    private $parameters = [];

    public function addParameter(Parameter $param)
    {
        $this->parameters[] = $param;
    }

    public function getParameters(): array
    {
        return (array) $this->parameters;
    }

    public function hasParameters(): bool
    {
        return !empty($this->parameters);
    }
}
