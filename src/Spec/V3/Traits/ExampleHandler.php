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
}
