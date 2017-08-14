<?php
/**
 * Created by PhpStorm.
 * User: dagho
 * Date: 8/11/2017
 * Time: 8:22 PM
 */

namespace OpenAPI\Spec\Entities\Helpers;


use OpenAPI\Spec\Entities\Components\ExternalDoc;

trait Documentable
{
    private $externalDoc;
    public function setExternalDoc(ExternalDoc $doc)
    {
        $this->externalDoc = $doc;
    }

    public function getExternalDoc(): ExternalDoc
    {
        return $this->externalDoc;
    }

    public function hasExternalDoc(): bool
    {
        return $this->externalDoc !== null;
    }
}