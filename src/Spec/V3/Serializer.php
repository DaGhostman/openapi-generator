<?php declare(strict_types=1);
namespace OpenAPI\Spec\V3;

use OpenAPI\Spec\Entities\Components\MediaType;
use OpenAPI\Spec\Entities\Components\Operation;
use OpenAPI\Spec\Entities\Components\Property;
use OpenAPI\Spec\Entities\Components\Response;
use OpenAPI\Spec\Entities\Components\Schema;
use OpenAPI\Spec\Entities\Document;
use OpenAPI\Spec\Entities\Param;
use OpenAPI\Spec\Entities\Path;
use OpenAPI\Spec\Entities\Server;
use OpenAPI\Spec\Entities\Tag;

class Serializer
{
    private $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function serialize(): array
    {
        $info = $this->document->getInfo();
        $result = [
            'openapi' => '3.0.0',
            'info' => $this->document->getInfo()->toArray(),
        ];

        foreach ($this->document->getServers() as $server) {
            /** @var Server $server */
            $serv = [
                'url' => $server->getUrl()
            ];

            if ($server->hasDescription()) {
                $serv['description'] = $server->getDescription();
            }

            if (!empty($server->getVariables())) {
                $serv['variables'] = $server->getVariables();
            }

            $result['servers'][] = $serv;
        }


        foreach ($this->document->getPaths() as $name => $path) {
            /** @var Path $path */
            $result['paths'][$name] = $path->toArray();

        }

        foreach ($this->document->getComponents() as $type => $components) {
            foreach ($components as $name => $component) {
                $result['components'][$type][$name] = $component->toArray();
            }
        }

        if ($this->document->hasSecurity()) {
            $result['security'] = [$this->document->getSecurity()];
        }

        foreach ($this->document->getTags() as $tag) {
            /** @var Tag $tag */
            $result['tags'][] = $tag->toArray();
        }

        if ($this->document->hasExternalDoc()) {
            $result['externalDocs'] = $this->document->getExternalDoc()->toArray();
        }

        return $result;
    }
}
