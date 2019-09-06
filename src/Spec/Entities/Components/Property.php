<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities\Components;

use Onion\Framework\Common\Hydrator\MethodHydrator;
use OpenAPI\Spec\Entities\Helpers\Formatted;
use OpenAPI\Spec\Entities\Helpers\Named;
use OpenAPI\Spec\Interfaces\Component;

class Property implements Component
{
    private $examples = [];
    private $enum = [];

    use Named, Formatted;

    use MethodHydrator;

    public function __construct(string $name, string $type, string $format = '')
    {
        $this->setName($name);
        $this->setType($type);
        $this->setFormat($format);
    }

    public function addExample(Component $example)
    {
        if (!$example instanceof ReferenceObject && !$example instanceof Example) {
            throw new \InvalidArgumentException('Invalid example provided');
        }

        $this->examples[] = $example;
    }

    public function getExamples(): array
    {
        return (array) $this->examples;
    }

    public function hasExamples(): bool
    {
        return !empty($this->examples);
    }

    public function setEnum(array $enum)
    {
        $this->enum = $enum;
    }

    public function getEnum(): array
    {
        return $this->enum;
    }

    public function addEnum($value)
    {
        $this->enum[] = $value;
    }

    public function hasEnum(): bool
    {
        return !empty($this->enum);
    }

    public function jsonSerialize(): array
    {
        $result = [
            'type' => $this->getType(),
        ];

        if ($this->getType() === 'array') {
            $result['items'] = [
                (stripos($this->getFormat(), '#') === 0 ? '$ref' : 'type') => $this->getFormat()
            ];
        } else {
            if ($this->hasFormat()) {
                $result[(stripos($this->getFormat(), '#') === 0 ? '$ref' : 'format')] = $this->getFormat();
            }
        }

        if ($this->hasEnum()) {
            $result['enum'] = $this->getEnum();
        }

        if ($this->hasExamples()) {
            foreach ($this->getExamples() as $name => $example) {
                $result['example'] = $example->getValue();
            }
        }

        return $result;
    }
}
