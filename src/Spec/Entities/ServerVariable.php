<?php
/**
 * Created by PhpStorm.
 * User: dagho
 * Date: 8/11/2017
 * Time: 8:14 PM
 */

namespace OpenAPI\Spec\Entities;

use OpenAPI\Spec\Entities\Helpers\Describable;

class ServerVariable
{
    private $default;
    /**
     * @var string[]
     */
    private $enum = [];

    use Describable;

    public function __construct(string $value)
    {
        $this->default = $value;
    }

    public function setEnum(array $enum)
    {
        $this->enum = $enum;
    }

    public function getEnum(): array
    {
        return $this->enum;
    }

    public function addEnum(string $value)
    {
        $this->enum[] = $value;
    }
}