<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities\Helpers;

trait Taggable
{
    private $tags;

    public function addTag(string $tag)
    {
        $this->tags[] = $tag;
    }

    public function hasTags(): bool
    {
        return !empty($this->tags);
    }

    public function getTags(): array
    {
        return (array) $this->tags;
    }
}