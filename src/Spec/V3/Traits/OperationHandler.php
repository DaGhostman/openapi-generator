<?php
namespace OpenAPI\Spec\V3\Traits;

use OpenAPI\Spec\Entities\Components\Operation;

trait OperationHandler
{
    use ParameterHandler;
    use ResponseHandler;
    use ReferenceObjectHandler;

    private static function serializeOperation(Operation $operation)
    {
        $result = $operation->extract();

        if (isset($result['parameters'])) {
            foreach ($result['parameters'] as $index => $parameter) {
                $result['parameters'][$index] = static::serializeParameter($parameter);
            }
        }

        if (isset($result['responses'])) {
            foreach($result['responses'] as $status => $response) {
                $r = clone $response;
                $r->setName('');
                $result['responses'][$status] = static::serializeResponse($r);
            }
        }

        if (isset($result['requestBody'])) {
            $result['requestBody'] = static::serializeReferenceObject($result['requestObject']);
        }

        return $result;
    }
}
