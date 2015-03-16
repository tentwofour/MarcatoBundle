<?php

namespace Ten24\MarcatoIntegrationBundle\Service;

use JMS\Serializer\DeserializationContext;
use JMS\Serializer\Serializer;

/**
 * Class EntityParser
 * @package Ten24\MarcatoIntegrationBundle\Service
 */
class EntityParser
{
    /**
     * @var \JMS\Serializer\Serializer
     */
    private $serializer;

    const TYPE_ARTIST = 'Ten24\MarcatoIntegrationBundle\Entity\Artist';
    const TYPE_CONTACT = 'Ten24\MarcatoIntegrationBundle\Entity\Contact';
    const TYPE_SHOW = 'Ten24\MarcatoIntegrationBundle\Entity\Show';
    const TYPE_VENUE = 'Ten24\MarcatoIntegrationBundle\Entity\Venue';
    const TYPE_WORKSHOP = 'Ten24\MarcatoIntegrationBundle\Entity\Workshop';

    /**
     * @var array
     */
    private $feedToEntityMapping = array(
        Downloader::FEED_TYPE_ARTISTS => self::TYPE_ARTIST,
        Downloader::FEED_TYPE_CONTACTS => self::TYPE_CONTACT,
        Downloader::FEED_TYPE_SHOWS => self::TYPE_SHOW,
        Downloader::FEED_TYPE_VENUES => self::TYPE_VENUE,
        Downloader::FEED_TYPE_WORKSHOPS => self::TYPE_WORKSHOP,
    );

    /**
     * @param \JMS\Serializer\Serializer $serializer
     */
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Parse passed xml into type (Entity)
     * @param null $feedType
     * @param string $xml
     * @return mixed|object
     */
    public function parse($feedType = null, $xml = '')
    {
        // Find the entity type that maps to the feed type
        if (null === ($entityType = $this->getEntityMappingForFeedType($feedType)))
        {
            throw new \RuntimeException(sprintf('Entity for "%s" does not exist', $feedType));
        }

        // This needs to be the pluralized entity name
        // ie. Artists, Workshops, Contacts, etc.
        // as the Marcato root XML node is one <artists> node
        // that contains a collection of <artist> nodes
        $collectionEntityType = $entityType.'s';

        /** @var \JMS\Serializer\DeserializationContext $context */
        $context = DeserializationContext::create();
        $context->setSerializeNull(true);
        $context->enableMaxDepthChecks();

        return $this->serializer->deserialize($xml, $collectionEntityType, 'xml', $context);
    }

    /**
     * Get the entity mapping for the provided feed type
     * @param $feedType
     * @return null
     */
    private function getEntityMappingForFeedType($feedType)
    {
        if (array_key_exists($feedType, $this->feedToEntityMapping))
        {
            return $this->feedToEntityMapping[$feedType];
        }

        return null;
    }
}