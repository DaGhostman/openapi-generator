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
    private $externalDocs;
    public function setExternalDoc(ExternalDoc $doc)
    {
        $this->externalDocs = $doc;
    }

    public function getExternalDocs(): ?ExternalDoc
    {
        return $this->externalDocs;
    }

    public function hasExternalDocs(): bool
    {
        return $this->externalDocs !== null;
    }
}
