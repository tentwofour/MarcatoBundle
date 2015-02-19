<?php

namespace Ten24\MarcatoIntegrationBundle\Service;

class ArrayParser extends AbstractParser
{
    /**
     * Parse passed XML into array
     * @param null $xml
     * @return mixed
     */
    public function parse($xml = null)
    {
        return $this->serializer->decode($xml, 'xml');
    }
}