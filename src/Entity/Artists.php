<?php

namespace Ten24\MarcatoIntegrationBundle\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Artists
 * Class to deal with JMS serialization/deserialization,
 * as the Marcato data always has a root of <artists>,
 * which is a collection of <artist> nodes
 */
class Artists
{
    /**
     * @Serializer\Type("array<Ten24\MarcatoIntegrationBundle\Entity\Artist>")
     * @Serializer\XmlList(entry="artist")
     */
    protected $artists;

    public function getArtists()
    {
        return $this->artists;
    }
}