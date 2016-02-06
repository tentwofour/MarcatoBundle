<?php

namespace Ten24\MarcatoIntegrationBundle\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Shows
 * Class to deal with JMS serialization/deserialization,
 * as the Marcato data always has a root of <shows>,
 * which is a collection of <show> nodes
 *
 */
class Shows
{
    /**
     * @Serializer\Type("ArrayCollection<Ten24\MarcatoIntegrationBundle\Entity\Show>")
     * @Serializer\XmlList(entry="show")
     */
    protected $shows;

    /**
     * Get an array of Ten24\MarcatoIntegrationBundle\Entity\Show
     *
     * @return array
     */
    public function getShows()
    {
        return $this->shows;
    }
}