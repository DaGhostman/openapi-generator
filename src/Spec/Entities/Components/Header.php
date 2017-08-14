<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities\Components;

class Header extends Param
{
    public function __construct($name, $allowEmpty = false, $deprecated = false)
    {
        parent::__construct($name, $allowEmpty, $deprecated);
        $this->setRequired(false);
    }

    public function toArray(): array
    {
        $result = parent::toArray();
        $result['schema'] = [
            'type' => $this->getType(),
            'format' => $this->getFormat()
        ];

        unset($result['in']);
        unset($result['name']);
        return $result;
    }
}