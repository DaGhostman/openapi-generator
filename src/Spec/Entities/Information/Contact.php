<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities\Information;

use OpenAPI\Spec\Entities\Helpers\Named;
use OpenAPI\Spec\Interfaces\Component;

class Contact implements Component
{
    private $url;
    private $email;

    use Named;

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function hasEmail(): bool
    {
        return $this->email !== null;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    public function hasUrl(): bool
    {
        return $this->url !== null;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
    public function toArray(): array
    {
        $result = [];

        if ($this->hasName()) {
            $result['name'] = $this->getName();
        }
        if ($this->hasEmail()) {
            $result['email'] = $this->getEmail();
        }

        if ($this->hasUrl()) {
            $result['url'] = $this->getUrl();
        }

        return $result;
    }
}
