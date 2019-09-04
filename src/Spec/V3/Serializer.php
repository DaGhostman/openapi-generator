<?php declare(strict_types=1);
namespace OpenAPI\Spec\V3;

use OpenAPI\Spec\Entities\Document;
use OpenAPI\Spec\Entities\Path;
use OpenAPI\Spec\Entities\Tag;

class Serializer
{
    private $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function serialize(): string
    {
        $result = [
            'openapi' => '3.0.0',
            'info' => $this->document->getInfo(),
        ];

        if ($this->document->getServers() !== []) {
            $result['servers'] = $this->document->getServers();
        }

        foreach ($this->document->getPaths() as $name => $path) {
            /** @var Path $path */
            $result['paths'][$name] = $path;

        }

        foreach ($this->document->getComponents() as $type => $components) {
            foreach ($components as $name => $component) {
                $result['components'][$type][$name] = $component;
            }
        }

        if ($this->document->hasSecurity()) {
            $result['security'] = [$this->document->getSecurity()];
        }

        foreach ($this->document->getTags() as $tag) {
            /** @var Tag $tag */
            $result['tags'][] = $tag;
        }

        if ($this->document->hasExternalDoc()) {
            $result['externalDocs'] = $this->document->getExternalDoc();
        }

        return json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
