<?php
namespace OpenAPI\Spec\Entities\Components;

use Onion\Framework\Common\Hydrator\MethodHydrator;
use OpenAPI\Spec\Entities\Helpers\Describable;
use OpenAPI\Spec\Entities\Helpers\Documentable;
use OpenAPI\Spec\Entities\Helpers\Named;
use OpenAPI\Spec\Entities\Helpers\Parametrised;
use OpenAPI\Spec\Entities\Helpers\Secured;
use OpenAPI\Spec\Entities\Helpers\Taggable;
use OpenAPI\Spec\Entities\Server;
use OpenAPI\Spec\Interfaces\Component;

class Operation implements Component
{
    private $id;
    private $deprecated;
    private $responses = [];
    private $security = [];
    private $servers = [];
    private $requestBody;

    use Named, Describable, Documentable, Taggable, Secured, Parametrised;
    use MethodHydrator;

    public function __construct(string $name, bool $deprecated = false)
    {
        $this->setName($name);
        $this->deprecated = $deprecated;
    }

    public function hasOperationId(): bool
    {
        return $this->id !== null;
    }

    public function getOperationId(): ?string
    {
        return $this->id;
    }

    public function setOperationId(string $id)
    {
        $this->id = $id;
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

    public function setRequestBody(ReferenceObject $requestBody)
    {
        $this->requestBody = $requestBody;
    }

    public function hasRequestBody(): bool
    {
        return $this->requestBody !== null;
    }

    public function getRequestBody(): ?ReferenceObject
    {
        return $this->requestBody;
    }

    public function jsonSerialize(): array
    {
        $result = [];

        if ($this->hasDescription()) {
            $result['description'] = $this->getDescription();
        }

        if ($this->hasOperationId()) {
            $result['operationId'] = $this->getOperationId();
        }

        if ($this->hasSummary()) {
            $result['summary'] = $this->getSummary();
        }

        if ($this->hasParameters()) {
            foreach ($this->getParameters() as $parameter) {
                $result['parameters'][] = $parameter;
            }
        }
        foreach ($this->getResponses() as $status => $response) {
            $result['responses'][$status] = $response;
        }

        if ($this->hasRequestBody()) {
            $result['requestBody'] = $this->getRequestBody();
        }

        if ($this->hasSecurity()) {
            $result['security'] = $this->getSecurity();
        }

        foreach ($this->getTags() as $tag) {
            $result['tags'][] = $tag;
        }

        return $result;
    }
}
