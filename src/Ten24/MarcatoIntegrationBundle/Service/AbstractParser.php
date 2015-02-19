<?php

namespace Ten24\MarcatoIntegrationBundle\Service;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

abstract class AbstractParser
{
    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @todo -pass encoders, and normalizers in DIC
     */
    public function __construct()
    {
        $encoders = array(new XmlEncoder());
        $normalizers = array(new GetSetMethodNormalizer());

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @param null $xml
     * @return mixed
     */
    abstract public function parse($xml = null);
}