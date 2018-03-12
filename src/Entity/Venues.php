<?php

namespace Ten24\MarcatoIntegrationBundle\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Venues
 * Class to deal with JMS serialization/deserialization,
 * as the Marcato data always has a root of <venues>,
 * which is a collection of <venue> nodes
 *
 */
class Venues
{
    /**
     * @Serializer\Type("array<Ten24\MarcatoIntegrationBundle\Entity\Venue>")
     * @Serializer\XmlList(entry="venue")
     */
    protected $venues;

    /**
     * Get an array of Ten24\MarcatoIntegrationBundle\Entity\Venue
     *
     * @return array
     */
    public function getVenues()
    {
        return $this->venues;
    }
}