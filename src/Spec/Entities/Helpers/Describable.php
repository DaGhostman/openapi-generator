<?php
/**
 * Created by PhpStorm.
 * User: dagho
 * Date: 8/11/2017
 * Time: 8:15 PM
 */

namespace OpenAPI\Spec\Entities\Helpers;


trait Describable
{
    private $description;
    private $summary;

    public function getDescription(): string
    {
        return (string) $this->description;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function hasDescription(): bool
    {
        return $this->description !== null && $this->description !== '';
    }

    public function getSummary(): string
    {
        return $this->summary;
    }

    public function setSummary(string $summary)
    {
        $this->summary = $summary;
    }

    public function hasSummary(): bool
    {
        return $this->summary !== null;
    }
}
