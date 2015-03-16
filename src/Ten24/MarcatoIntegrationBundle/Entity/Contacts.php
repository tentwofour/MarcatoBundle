<?php

namespace Ten24\MarcatoIntegrationBundle\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Contacts
 * Class to deal with JMS serialization/deserialization,
 * as the Marcato data always has a root of <contacts>,
 * which is a collection of <contact> nodes
 *
 */
class Contacts
{
    /**
     * @Serializer\Type("array<Ten24\MarcatoIntegrationBundle\Entity\Contact>")
     * @Serializer\XmlList(entry="contact")
     */
    protected $contacts;

    /**
     * Get an array of Ten24\MarcatoIntegrationBundle\Entity\Contact
     * @return array
     */
    public function getContacts()
    {
        return $this->contacts;
    }
}