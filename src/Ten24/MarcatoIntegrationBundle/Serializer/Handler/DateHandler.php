<?php

namespace Ten24\MarcatoIntegrationBundle\Serializer\Handler;

use JMS\Serializer\Exception\RuntimeException;
use JMS\Serializer\Handler\DateHandler as BaseDateHandler;
use JMS\Serializer\XmlDeserializationVisitor;

class DateHandler extends BaseDateHandler
{
    /**
     * @var string
     */
    private $defaultFormat;

    /**
     * @var string
     */
    private $defaultTimezone;

    /**
     * @var boolean
     */
    private $xmlCData;

    /**
     * @param string $defaultFormat
     * @param string $defaultTimezone
     * @param bool   $xmlCData
     */
    public function __construct($defaultFormat = \DateTime::ISO8601,
                                $defaultTimezone = 'UTC',
                                $xmlCData = true)
    {
        $this->defaultFormat   = $defaultFormat;
        $this->defaultTimezone = new \DateTimeZone($defaultTimezone);
        $this->xmlCData        = $xmlCData;
    }

    /**
     * This method needed to be overridden from JMS's - Marcato passes <date nil=true /> nodes
     * but JMS looks for the xsi:nil attribute
     *
     * @see \JMS\Serializer\Handler\DateHandler#deserializeDateTimeFromXml()
     *
     * @param XmlDeserializationVisitor $visitor
     * @param                           $data
     * @param array                     $type
     *
     * @return \DateTime|null
     */
    public function deserializeDateTimeFromXml(XmlDeserializationVisitor $visitor,
                                               $data,
                                               array $type)
    {
        $attributes = $data->attributes();

        if (isset($attributes['nil'][0]) && (string)$attributes['nil'][0] === 'true')
        {
            return null;
        }

        return $this->parseDateTime($data, $type);
    }

    /**
     * @param       $data
     * @param array $type
     *
     * @return \DateTime
     */
    private function parseDateTime($data,
                                   array $type)
    {
        $timezone = isset($type['params'][1]) ? new \DateTimeZone($type['params'][1]) : $this->defaultTimezone;
        $format   = $this->getFormat($type);
        $datetime = \DateTime::createFromFormat($format, ltrim(trim((string)$data)), $timezone);

        if (false === $datetime)
        {
            throw new RuntimeException(sprintf('Invalid datetime "%s", expected format %s.', $data, $format));
        }

        return $datetime;
    }

    /**
     * @return string
     *
     * @param array $type
     */
    private function getFormat(array $type)
    {
        return isset($type['params'][0]) ? $type['params'][0] : $this->defaultFormat;
    }
}