<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities\Helpers;

use OpenAPI\Spec\Entities\Components\Param;

trait Parametrised
{
    private $parameters = [];

    public function addParameter(Param $param)
    {
        $this->parameters[$param->getName() . ':' . $param->getPlace()] = $param;
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
