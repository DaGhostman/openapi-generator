<?php
namespace OpenAPI\Spec\Entities\Components;

class Responses
{
    private $responses = [];

    public function addResponse(string $status, Response $response)
    {
        $this->responses[$status] = $response;
    }
}
