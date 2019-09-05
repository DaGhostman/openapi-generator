<?php
/**
 * Created by PhpStorm.
 * User: dagho
 * Date: 8/12/2017
 * Time: 2:15 PM
 */

namespace OpenAPI\Spec\Entities\Components;

use Onion\Framework\Common\Hydrator\MethodHydrator;
use OpenAPI\Spec\Entities\Helpers\Describable;
use OpenAPI\Spec\Entities\Helpers\Named;
use OpenAPI\Spec\Interfaces\Component;

class ExternalDoc implements Component
{
    use Named, Describable;

    use MethodHydrator;

    public function __construct(string $url)
    {
        $this->setName($url);
    }

    public function jsonSerialize(): array
    {
        $result = [
            'url' => $this->name
        ];

        if ($this->hasDescription()) {
            $result['description'] = $this->getDescription();
        }

        return $result;
    }
}
