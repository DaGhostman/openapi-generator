<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities\Components;

use Onion\Framework\Common\Hydrator\MethodHydrator;
use OpenAPI\Spec\Entities\Helpers\Describable;
use OpenAPI\Spec\Entities\Helpers\Named;
use OpenAPI\Spec\Interfaces\Component;

class Example implements Component
{
    private $value;
    private $externalValue;

    use Describable, Named;
    use MethodHydrator;

    public function __construct($value, bool $external = false, string $name = null)
    {

        $this->value = $value;
        if ($external) {
            $this->externalValue = $value;
            unset($this->value);
        }
        $this->setName((string) $name);
    }

    public function getValue()
    {
        return $this->value;
    }

    public function hasExternalValue(): bool
    {
        return $this->externalValue !== null;
    }

    public function jsonSerialize(): array
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
