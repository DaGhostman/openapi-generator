<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities\Components;

use OpenAPI\Spec\Entities\Helpers\Describable;
use OpenAPI\Spec\Entities\Helpers\Named;
use OpenAPI\Spec\Interfaces\Component;

class Response implements Component
{
    private $headers = [];
    private $content = [];
    private $links = [];

    use Named, Describable;
    public function __construct(string $statusCode = '200')
    {
        $this->setName($statusCode);
    }

    public function addHeader(Header $header)
    {
        $this->headers[$header->getName()] = $header;
    }

    public function getHeaders(): array
    {
        return (array) $this->headers;
    }

    public function hasHeaders(): bool
    {
        return !empty($this->headers);
    }

    public function addContent(string $contentType, MediaType $type)
    {
        $this->content[$contentType] = $type;
    }

    public function getContent(): array
    {
        return $this->content;
    }

    public function hasContent(): bool
    {
        return !empty($this->content);
    }

    public function addLink(string $name, ReferenceObject $referenceObject)
    {
        $this->links[$name] = $referenceObject;
    }

    public function getLinks(): array
    {
        return $this->links;
    }

    public function jsonSerialize(): array
    {
        $result = [
            'description' => $this->getDescription()
        ];

        if ($this->hasHeaders()) {
            foreach ($this->getHeaders() as $name => $header) {
                /** @var Header|ReferenceObject $header */
                $result['headers'][$name] = array_filter($header->jsonSerialize(), function ($key) {
                    if (!in_array($key, ['schema', 'description'])) {
                        return false;
                    }

                    return true;
                }, ARRAY_FILTER_USE_KEY);
            }
        }

        if ($this->hasContent()) {
            foreach ($this->getContent() as $type => $content) {
                /** @var MediaType $content */
                $result['content'][$type] = $content;
            }
        }

        return $result;
    }
}
