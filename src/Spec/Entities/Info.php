<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities;

use OpenAPI\Spec\Entities\Helpers\Describable;
use OpenAPI\Spec\Entities\Information\Contact;
use OpenAPI\Spec\Entities\Information\License;
use OpenAPI\Spec\Interfaces\Serializable;

class Info implements Serializable
{
    private $title;
    private $version;
    private $termsUrl;

    private $contact;
    private $license;

    use Describable;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function setTermsUrl(string $url)
    {
        $this->termsUrl = $url;
    }

    public function hasTermsUrl(): bool
    {
        return $this->termsUrl !== null;
    }

    public function getTermsUrl(): string
    {
        return $this->termsUrl;
    }

    public function setContact(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function hasContact(): bool
    {
        return $this->contact !== null;
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }

    public function setLicense(License $license)
    {
        $this->license = $license;
    }

    public function hasLicense(): bool
    {
        return $this->license !== null;
    }

    public function getLicense(): License
    {
        return $this->license;
    }

    public function toArray(): array
    {
        $result = [
            'title' => $this->getTitle(),
            'version' => $this->getVersion()
        ];

        if ($this->hasDescription()) {
            $result['description'] = $this->getDescription();
        }

        if ($this->hasTermsUrl()) {
            $result['termsOfService'] = $this->getTermsUrl();
        }

        if ($this->hasContact()) {
            $result['contact'] = $this->contact->toArray();
        }

        if ($this->hasLicense()) {
            $result['license'] = $this->license->toArray();
        }

        return $result;
    }
}
