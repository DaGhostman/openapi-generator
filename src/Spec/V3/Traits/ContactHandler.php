<?php
namespace OpenAPI\Spec\V3\Traits;

use OpenAPI\Spec\Entities\Information\Contact;

trait ContactHandler
{
    private static function serializeContact(Contact $contact): iterable
    {
        return $contact->extract();
    }

    private static function parseContact(iterable $data)
    {
        (new Contact)->hydrate($data);
    }
}
