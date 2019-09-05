<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities;

use Onion\Framework\Common\Hydrator\MethodHydrator;
use Onion\Framework\Hydrator\Interfaces\HydratableInterface;
use OpenAPI\Spec\Entities\Helpers\Describable;
use OpenAPI\Spec\Entities\Information\Contact;
use OpenAPI\Spec\Entities\Information\License;

class Info implements HydratableInterface
{
    private $title;
    private $version;
    private $termsUrl = '';

    private $contact;
    private $license;

    use Describable;
    use MethodHydrator;

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

    public function setTermsOfService(string $url)
    {
        $this->termsUrl = $url;
    }

    public function hasTermsOfService(): bool
    {
        return $this->termsUrl !== null;
    }

    public function getTermsOfService(): string
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

    public function getContact(): ?Contact
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

    public function getLicense(): ?License
    {
        return $this->license;
    }
}
