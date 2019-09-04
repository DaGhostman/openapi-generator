<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities\Components;

use OpenAPI\Spec\Interfaces\Component;

class MediaType implements Component
{
    private $encoding;
    private $examples = [];
    private $referenceObject;

    public function __construct(ReferenceObject $referenceObject)
    {
        $this->referenceObject = $referenceObject;
    }

    public function addExample(string $name, Component $example)
    {
        if (!$example instanceof ReferenceObject && !$example instanceof Example) {
            throw new \InvalidArgumentException('Invalid example provided');
        }

        $this->examples[$name] = $example;
    }

    public function getExamples(): array
    {
        return (array) $this->examples;
    }

    public function hasExamples(): bool
    {
        return !empty($this->examples);
    }

    public function jsonSerialize(): array
    {
        $result = [
            'schema' => [
                '$ref' => $this->referenceObject->getRef()
            ]
        ];

        if ($this->hasExamples()) {
            foreach ($this->getExamples() as $name => $example) {
                $result['examples'][$name] = $example;
            }
        }

        return $result;
    }
}
