<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities\Components;

use OpenAPI\Spec\Entities\Helpers\Describable;
use OpenAPI\Spec\Interfaces\Component;

class Example implements Component
{
    private $value;
    private $externalValue;

    use Describable;

    public function __construct($value, bool $external = false)
    {
        $this->value = $value;
        if ($external) {
            $this->externalValue = $value;
            unset($this->value);
        }
    }

    public function getValue()
    {
        return $this->value;
    }

    public function hasExternalValue(): bool
    {
        return $this->externalValue !== null;
    }

    public function toArray(): array
    {
        $result = [];
        if ($this->hasSummary()) {
            $result['summary'] = $this->getSummary();
        }

        if ($this->hasDescription()) {
            $result['description'] = $this->getDescription();
        }

        if ($this->hasExternalValue()) {
            $result['externalValue'] = json_encode($this->getValue());
        } else {
            $result['value'] = json_encode($this->getValue(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }

        return $result;
    }
}