<?php

namespace Ten24\MarcatoIntegrationBundle\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Workshops
 * Class to deal with JMS serialization/deserialization,
 * as the Marcato data always has a root of <workshops>,
 * which is a collection of <workshop> nodes
 *
 */
class Workshops
{
    /**
     * @Serializer\Type("array<Ten24\MarcatoIntegrationBundle\Entity\Workshop>")
     * @Serializer\XmlList(entry="workshop")
     */
    protected $workshops;

    /**
     * Get an array of Ten24\MarcatoIntegrationBundle\Entity\Workshop
     *
     * @return array
     */
    public function getWorkshops()
    {
        return $this->workshops;
    }
}