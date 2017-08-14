<?php
/**
 * Created by PhpStorm.
 * User: dagho
 * Date: 8/11/2017
 * Time: 10:10 PM
 */

namespace OpenAPI\Spec\Entities\Components;


class Responses
{
    private $responses = [];

    public function addResponse(string $status, Response $response)
    {
        $this->responses[$status] = $response;
    }
}