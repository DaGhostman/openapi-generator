<?php
namespace OpenAPI\Spec\V3\Traits;

use OpenAPI\Spec\Entities\Components\Operation;
use OpenAPI\Spec\Entities\Components\ReferenceObject;
use OpenAPI\Spec\Entities\Components\Response;

trait OperationHandler
{
    use ParameterHandler;
    use ResponseHandler;
    use ReferenceObjectHandler;
    use RequestBodyHandler;

    private static function serializeOperation(Operation $operation)
    {
        $result = $operation->extract([
            'description',
            'operationId',
            'summary',
            'parameters',
            'responses',
            'requestBody',
            'security',
            'tags',
        ], Operation::EXCLUDE_EMPTY | Operation::USE_RAW_KEYS);

        if (isset($result['parameters'])) {
            foreach ($result['parameters'] as $index => $parameter) {
                $result['parameters'][$index] = static::serializeParameter($parameter);
            }
        }

        if (isset($result['responses'])) {
            foreach($result['responses'] as $status => $response) {
                if ($response instanceof Response) {
                    $r = clone $response;
                    $r->setName('');
                    $result['responses'][$status] = static::serializeResponse($r);
                }

                if ($response instanceof ReferenceObject) {
                    $result['responses'][$status] = static::serializeReferenceObject($response);
                }
            }
        }

        if (isset($result['requestBody'])) {
            $result['requestBody'] = static::serializeRequestBody($result['requestObject']);
        }

        return $result;
    }

    private static function parseOperation(string $name, array $operation): Operation
    {
        if (isset($operation['requestBody'])) {
            $operation['requestBody'] = static::parseRequestBody($operation['requestBody']);
        }

        /** @var Operation $object */
        $object = (new Operation($name))->hydrate($operation);
        foreach ($operation['responses'] ?? [] as $code => $response) {
            if (isset($response['$ref'])) {
                $object->addResponse($code, static::parseReferenceObject($response));
                continue;
            }

            $object->addResponse($code, static::parseResponse($code, $response));
        }

        return $object;
    }
}
