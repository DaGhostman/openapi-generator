<?php
/**
 * Created by PhpStorm.
 * User: dagho
 * Date: 8/11/2017
 * Time: 9:14 PM
 */

namespace OpenAPI\Spec\Entities\Components;


use OpenAPI\Spec\Entities\Helpers\Describable;
use OpenAPI\Spec\Entities\Helpers\Named;
use OpenAPI\Spec\Interfaces\Component;

class RequestBody implements Component
{
    private $required;
    private $content = [];

    use Named, Describable;
    public function __construct(string $name, bool $required = false)
    {
        $this->setName($name);
        $this->required = $required;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function addContent(string $name, MediaType $type)
    {
        $this->content[$name] = $type;
    }

    public function jsonSerialize(): array
    {
        $response = [
            'content' => [],
        ];
        foreach ($this->content as $mime => $content) {
            $response['content'][$mime] = $content;
        }

        return $response;
    }
}
