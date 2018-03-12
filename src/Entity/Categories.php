<?php

namespace Ten24\MarcatoIntegrationBundle\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Contacts
 * Class to deal with JMS serialization/deserialization,
 * as the Marcato data always has a root of <tags>,
 * which is a collection of <tag> nodes
 *
 */
class Categories
{
    /**
     * @Serializer\Type("array<Ten24\MarcatoIntegrationBundle\Entity\Tag>")
     * @Serializer\XmlList(entry="tag")
     */
    protected $tags;

    /**
     * Get an array of Ten24\MarcatoIntegrationBundle\Entity\Tag
     *
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }
}