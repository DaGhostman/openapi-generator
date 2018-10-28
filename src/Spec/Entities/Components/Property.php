<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities\Components;

use OpenAPI\Spec\Entities\Helpers\Formatted;
use OpenAPI\Spec\Entities\Helpers\Named;
use OpenAPI\Spec\Interfaces\Component;

class Property implements Component
{
    private $examples = [];
    private $values = [];

    use Named, Formatted;

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

    public function setValues(string $values)
    {
        $this->values = $values;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function hasValues(): bool
    {
        return !empty($this->values);
    }

    public function toArray(): array
    {
        $result = [
            'type' => $this->getType(),
        ];

        if ($this->getType() === 'array') {
            $result['items'] = [
                strpos($this->getFormat(), '#') === 0 ? '$ref' : 'type' => $this->getFormat()
            ];
        } else {
            if ($this->hasFormat()) {
                $result['format'] = $this->getFormat();
            }
        }

        if ($this->hasValues()) {
            $result['enum'] = $this->getValues();
        }

        if ($this->hasExamples()) {
            foreach ($this->getExamples() as $name => $example) {
                $result['example'] = $example->getValue();
            }
        }

        return $result;
    }
}
