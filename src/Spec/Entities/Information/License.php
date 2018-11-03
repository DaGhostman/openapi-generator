<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities\Information;

use OpenAPI\Spec\Entities\Helpers\Named;
use OpenAPI\Spec\Interfaces\Component;

class License implements Component
{
    private $url;

    use Named;

    public function __construct(string $name)
    {
        $this->setName($name);
    }

    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    public function hasUrl(): bool
    {
        return $this->url !== null && $this->url !== '';
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function toArray(): array
    {
        $result = [
            'name' => $this->getName()
        ];

        if ($this->hasUrl()) {
            $result['url'] = $this->getUrl();
        }

        return $result;
    }
}
