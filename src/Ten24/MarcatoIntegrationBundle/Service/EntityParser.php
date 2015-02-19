<?php

namespace Ten24\MarcatoIntegrationBundle\Service;

/**
 * Class EntityParser
 * @package Ten24\MarcatoIntegrationBundle\Service
 * @todo
 */
class EntityParser extends AbstractParser
{
    const TYPE_ARTIST = 'Ten24\MarcatoIntegrationBundle\Entity\Artist';
    const TYPE_CONTACT = 'Ten24\MarcatoIntegrationBundle\Entity\Contact';
    const TYPE_SHOW = 'Ten24\MarcatoIntegrationBundle\Entity\Show';
    const TYPE_VENUE = 'Ten24\MarcatoIntegrationBundle\Entity\Venue';
    const TYPE_WORKSHOP = 'Ten24\MarcatoIntegrationBundle\Entity\Workshop';

    private $validTypes = array(
        self::TYPE_ARTIST,
        self::TYPE_CONTACT,
        self::TYPE_SHOW,
        self::TYPE_VENUE,
        self::TYPE_WORKSHOP
    );

    /**
     * Parse passed xml into type (Entity)
     * @param null $type
     * @param string $xml
     * @return mixed|object
     *
     * @todo - finish
     */
    public function parse($type = null, $xml = '')
    {
        if (!$this->isValidEntityType($type))
        {

        }

        return $this->serializer->deserialize($xml, $type, 'xml');
    }

    private function isValidEntityType($type)
    {
        return in_array($type, $this->validTypes);
    }
}