<?php
/**
 * Created by PhpStorm.
 * User: dagho
 * Date: 8/11/2017
 * Time: 8:58 PM
 */

namespace OpenAPI\Spec\Entities\Components;


use OpenAPI\Spec\Entities\Helpers\Describable;
use OpenAPI\Spec\Entities\Helpers\Documentable;
use OpenAPI\Spec\Entities\Helpers\Named;
use OpenAPI\Spec\Entities\Helpers\Taggable;
use OpenAPI\Spec\Entities\Security;
use OpenAPI\Spec\Entities\Server;
use OpenAPI\Spec\Interfaces\Component;

class Operation implements Component
{
    private $deprecated;
    private $responses = [];
    private $security = [];
    private $servers = [];

    use Named, Describable, Documentable, Taggable;

    public function __construct(string $name, bool $deprecated = false)
    {
        $this->setName($name);
        $this->deprecated = $deprecated;
    }

    public function isDeprecated(): bool
    {
        return $this->deprecated;
    }

    /**
     * @param string $statusCode
     * @param Response|ReferenceObject $response
     */
    public function addResponse(string $statusCode, Component $response)
    {
        $this->responses[$statusCode] = $response;
    }

    public function getResponses(): array
    {
        return (array) $this->responses;
    }

    public function hasResponses(): bool
    {
        return !empty($this->responses);
    }

    public function addSecurity(Security $security)
    {
        $this->security[$security->getName()] = $security;
    }

    public function getSecurity(): array
    {
        return (array) $this->security;
    }

    public function hasSecurity(): bool
    {
        return !empty($this->security);
    }

    public function addServer(Server $server)
    {
        $this->servers[] = $server;
    }

    public function getServers(): array
    {
        return (array) $this->servers;
    }

    public function hasServers(): bool
    {
        return !empty($this->servers);
    }

    public function toArray(): array
    {
        $result = [];
        foreach ($this->getResponses() as $status => $response) {
            $result['responses'][$status] = $response->toArray();
        }

        foreach ($this->getTags() as $tag) {
            $result['tags'][] = $tag;
        }

        return $result;
    }
}