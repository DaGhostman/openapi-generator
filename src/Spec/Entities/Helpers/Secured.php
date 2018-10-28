<?php declare(strict_types=1);
namespace OpenAPI\Spec\Entities\Helpers;

trait Secured
{
    private $security = [];

    public function addSecurity(string $scheme, array $scopes)
    {
        $this->security[$scheme] = $scopes;
    }

    public function hasSecurity()
    {
        return !empty($this->security);
    }

    public function getSecurity()
    {
        return $this->security;
    }
}
