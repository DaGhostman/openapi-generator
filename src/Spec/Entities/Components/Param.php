<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities\Components;

use OpenAPI\Spec\Entities\Helpers\Describable;
use OpenAPI\Spec\Entities\Helpers\Formatted;
use OpenAPI\Spec\Entities\Helpers\Named;
use OpenAPI\Spec\Interfaces\Component;

class Param implements Component
{
    private $required = true;
    private $place = 'url';
    private $deprecated;
    private $allowEmpty;

    use Named, Formatted, Describable;

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
        return $this->required;
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

    public function setPlace(string $place): Param
    {
        $this->place = $place;
        return $this;
    }

    public function toArray(): array
    {
        $result = [
            'name' => $this->getName(),
            'in' => $this->getPlace(),
            'deprecated' => $this->isDeprecated(),
            'allowEmptyValue' => $this->isAllowEmpty()
        ];

        if ($this->isRequired()) {
            $result['required'] = $this->isRequired();
        }

        if ($this->hasDescription()) {
            $result['description'] = $this->getDescription();
        }

        if ($this->hasType()) {
            $result['type'] = $this->getType();
        }

        return $result;
    }
}
