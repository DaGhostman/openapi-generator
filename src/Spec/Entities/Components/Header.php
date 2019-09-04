<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities\Components;

class Header extends Param
{
    public function __construct($name, $allowEmpty = false, $deprecated = false)
    {
        parent::__construct($name, $allowEmpty, $deprecated);
        $this->setRequired(false);
    }

    public function jsonSerialize(): array
    {
        $result = parent::jsonSerialize();
        $result['schema']['type'] = $this->getType();
        if ($this->hasFormat()) {
            $result['format'] = $this->getFormat();
        }

        unset($result['in']);
        unset($result['name']);
        return $result;
    }
}
