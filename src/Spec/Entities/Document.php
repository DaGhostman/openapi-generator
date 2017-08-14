<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities;

use OpenAPI\Spec\Entities\Components\Param;
use OpenAPI\Spec\Entities\Components\Response;
use OpenAPI\Spec\Entities\Components\Schema;
use OpenAPI\Spec\Entities\Helpers\Documentable;
use OpenAPI\Spec\Interfaces\Component;

class Document
{
    /**
     * @var Component[]
     */
    private $components = [];

    /**
     * @var Path[]
     */
    private $paths = [];

    /**
     * @var Tag[]
     */
    private $tags = [];

    /**
     * @var Info
     */
    private $info;

    /**
     * @var Server[]
     */
    private $servers;

    use Documentable;

    public function __construct(Info $info)
    {
        $this->info = $info;
    }

    public function getInfo(): Info
    {
        return $this->info;
    }

    public function addServer(Server $server) {
        $this->servers[] = $server;
    }

    public function getServers(): array
    {
        return $this->servers;
    }

    /**
     * @return Component[]
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    /**
     * @param Component[] $components
     * @return Document
     */
    public function setComponents(array $components): Document
    {
        $this->components = $components;
        return $this;
    }

    public function addComponent(Component $component)
    {
        if ($component instanceof Schema) {
            $type = 'schemas';
        }

        if ($component instanceof Param) {
            $type = 'parameters';
        }

        if ($component instanceof Response) {
            $type = 'responses';
        }

        if ($component instanceof Security) {
            $type = 'securitySchemes';
        }

        if (!isset($type)) {
            return;
        }

        $this->components[$type][$component->getName()] = $component;
    }

    public function addPath(Path $path)
    {
        $this->paths[$path->getName()] = $path;

        return $this;
    }

    public function getPaths(): array
    {
        return $this->paths;
    }

    public function hasSchema(string $name): bool
    {
        return isset($this->components['schemas'][$name]);
    }

    public function hasResponse(string $statusCode): bool
    {
        return isset($this->components['responses'][$statusCode]);
    }

    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;
    }

    public function getTags(): array
    {
        return $this->tags;
    }
}
