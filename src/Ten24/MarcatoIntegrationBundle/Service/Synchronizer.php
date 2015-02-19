<?php

namespace Ten24\MarcatoIntegrationBundle\Service;

use Guzzle\Http\Client;
use Guzzle\Http\EntityBodyInterface;
use Guzzle\Http\Exception\BadResponseException;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

/**
 * Class Synchronizer
 * @package Ten24\MarcatoIntegrationBundle\Service
 */
class Synchronizer
{
    /**
     * @var \Ten24\MarcatoIntegrationBundle\Service\Downloader
     */
    private $downloader;

    /**
     * @var \Ten24\MarcatoIntegrationBundle\Service\AbstractParser
     */
    private $parser;

    /**
     * @var \Ten24\MarcatoIntegrationBundle\Service\CacheProvider
     */
    private $cacheProvider;

    public function __construct(Downloader $downloader, AbstractParser $parser, CacheProvider $cacheProvider)
    {
        $this->downloader = $downloader;
        $this->parser = $parser;
        $this->cacheProvider = $cacheProvider;
    }

    public function synchronizeAll()
    {
        $xml = $this->downloader->retrieveAll();

        foreach($xml as $feedType => $xml)
        {
            $method = 'set'.ucfirst($feedType);
            $parsed = $this->parser->parse($xml);
            $this->cacheProvider->$method($parsed);
        }
    }

    public function synchronize()
    {
        $this->synchronizeAll();
    }

    public function synchronizeArtists()
    {
        $xml = $this->downloader->retrieveArtists();
        $parsed = $this->parser->parse($xml);
        $this->cacheProvider->setArtists(Downloader::FEED_TYPE_ARTISTS, $parsed);
    }

    public function synchronizeContacts()
    {
        $xml = $this->downloader->retrieveContacts();
        $parsed = $this->parser->parse($xml);
        $this->cacheProvider->setContacts(Downloader::FEED_TYPE_CONTACTS, $parsed);
    }

    public function synchronizeShows()
    {
        $xml = $this->downloader->retrieveShows();
        $parsed = $this->parser->parse($xml);
        $this->cacheProvider->setShows(Downloader::FEED_TYPE_SHOWS, $parsed);
    }

    public function synchronizeVenues()
    {
        $xml = $this->downloader->retrieveVenues();
        $parsed = $this->parser->parse($xml);
        $this->cacheProvider->setVenues(Downloader::FEED_TYPE_VENUES, $parsed);
    }

    public function synchronizeWorkshops()
    {
        $xml = $this->downloader->retrieveWorkshops();
        $parsed = $this->parser->parse($xml);
        $this->cacheProvider->setWorkshops(Downloader::FEED_TYPE_WORKSHOPS, $parsed);
    }
}