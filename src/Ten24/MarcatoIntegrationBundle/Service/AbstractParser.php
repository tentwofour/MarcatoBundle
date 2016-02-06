<?php

namespace Ten24\MarcatoIntegrationBundle\Service;

use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

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
        $encoders    = [new XmlEncoder()];
        $normalizers = [new GetSetMethodNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @param null $xml
     *
     * @return mixed
     */
    abstract public function parse($xml = null);
}