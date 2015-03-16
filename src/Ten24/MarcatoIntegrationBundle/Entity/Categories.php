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
class Categories
{
    /**
     * @Serializer\Type("array<Ten24\MarcatoIntegrationBundle\Entity\Tag>")
     * @Serializer\XmlList(entry="category")
     */
    protected $tags;

    /**
     * Get an array of Ten24\MarcatoIntegrationBundle\Entity\Tag
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }
}