<?php
namespace OpenAPI\Spec\V3\Traits;

use OpenAPI\Spec\Entities\Components\Example;

trait ExampleHandler
{
    private static function serializeExample(Example $example)
    {
        $result = $example->extract(['summary', 'description']);
        $key = 'value';
        if ($example->hasExternalValue()) {
            $key = 'externalValue';
        }

        $result[$key] = $example->getValue();

        return $result;
    }

    private static function parseExample($example): Example
    {
        return new Example(
            is_array($example) ? ($example['value'] ?? $example['externalValue']) : $example,
            is_array($example) && isset($example['externalValue'])
        );
    }
}
