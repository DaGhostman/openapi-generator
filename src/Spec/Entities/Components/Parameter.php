<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities\Components;

use Onion\Framework\Common\Hydrator\MethodHydrator;
use OpenAPI\Spec\Entities\Helpers\Describable;
use OpenAPI\Spec\Entities\Helpers\Formatted;
use OpenAPI\Spec\Entities\Helpers\Named;
use OpenAPI\Spec\Interfaces\Component;

class Parameter implements Component
{
    private $required = true;
    private $place = 'url';
    private $deprecated;
    private $allowEmpty;

    use Named, Formatted, Describable;
    use MethodHydrator;

    public function __construct(string $name, bool $allowEmpty = false, bool $deprecated = false)
    {
        $this->setName($name);
        $this->setType('string');
        $this->setFormat('');

        $this->deprecated = $deprecated;
        $this->allowEmpty = $allowEmpty;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function setRequired(bool $required)
    {
        $this->required = $required;
    }

    public function isDeprecated(): bool
    {
        return $this->deprecated;
    }

    public function setDeprecated(bool $deprecated)
    {
        $this->deprecated = $deprecated;
    }

    public function isAllowEmpty(): bool
    {
        return $this->allowEmpty;
    }

    public function setAllowEmpty(bool $allowEmpty)
    {
        $this->allowEmpty = $allowEmpty;
    }

    public function getPlace(): string
    {
        return $this->place;
    }

    public function setPlace(string $place): Parameter
    {
        $this->place = $place;
        return $this;
    }

    public function jsonSerialize(): array
    {
        $result = [
            'name' => $this->getName(),
            'in' => $this->getPlace(),
        ];

        $this->setRequired($this->isRequired() || $this->getPlace() === 'path');

        if ($this->isDeprecated()) {
            $result['deprecated'] = $this->isDeprecated();
        }

        if ($this->isAllowEmpty()) {
            $result['allowEmptyValue'] = $this->isAllowEmpty();
        }
        $result['required'] = $this->isRequired();

        if ($this->hasDescription()) {
            $result['description'] = $this->getDescription();
        }

        if ($this->hasType()) {
            $result['schema']['type'] = $this->getType();
        }

        if ($this->hasFormat()) {
            $result['schema']['format'] = $this->getFormat();
        }

        return $result;
    }
}
