<?php
/**
 * Created by PhpStorm.
 * User: dagho
 * Date: 8/11/2017
 * Time: 8:33 PM
 */

namespace OpenAPI\Spec\Entities\Helpers;


trait Formatted
{
    use Typed;
    private $format;

    public function setFormat(string $format)
    {
        $this->format = $format;
    }

    public function getFormat(): string
    {
        return (string) $this->format;
    }

    public function hasFormat(): bool
    {
        return $this->format !== null && $this->format !== '';
    }
}
