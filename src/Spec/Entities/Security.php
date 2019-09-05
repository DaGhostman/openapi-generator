<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities;

use Onion\Framework\Common\Hydrator\MethodHydrator;
use OpenAPI\Spec\Entities\Helpers\Describable;
use OpenAPI\Spec\Entities\Helpers\Named;
use OpenAPI\Spec\Entities\Helpers\Typed;
use OpenAPI\Spec\Interfaces\Component;

class Security implements Component
{
    private $name;
    private $values;
    private $place;
    private $scheme;
    private $bearerFormat;
    private $openIdConnectUrl;

    use Named, Typed, Describable;
    use MethodHydrator;

    public function __construct(string $name = '')
    {
        $this->setName($name);
    }

    public function setPlace(string $place)
    {
        $this->place = $place;
    }

    public function getPlace(): string
    {
        return $this->place;
    }

    public function setBearerFormat(string $format)
    {
        $this->bearerFormat = $format;
    }

    public function hasBearerFormat(): bool
    {
        return $this->bearerFormat !== null && $this->bearerFormat !== '';
    }

    public function getBearerFormat(): string
    {
        return $this->bearerFormat;
    }

    public function setOpenIdConnectUrl(string $url)
    {
        $this->openIdConnectUrl = $url;
    }

    public function hasOpenIdConnectUrl(): bool
    {
        return $this->openIdConnectUrl !== null;
    }

    public function getOpenIdConnectUrl(): string
    {
        return $this->openIdConnectUrl;
    }

    public function setScheme(string $scheme)
    {
        $this->scheme = $scheme;
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }
}
