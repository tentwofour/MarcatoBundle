<?php

namespace Ten24\MarcatoIntegrationBundle\Service;

use Guzzle\Http\Client;
use Guzzle\Http\EntityBodyInterface;
use Guzzle\Http\Exception\BadResponseException;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class Downloader
{
    /**
     *
     */
    const FEED_TYPE_ARTISTS = 'artists';

    /**
     *
     */
    const FEED_TYPE_CONTACTS = 'contacts';

    /**
     *
     */
    const FEED_TYPE_SHOWS = 'shows';

    /**
     *
     */
    const FEED_TYPE_PERFORMANCES = 'performances';

    /**
     *
     */
    const FEED_TYPE_VENUES = 'venues';

    /**
     *
     */
    const FEED_TYPE_WORKSHOPS = 'workshops';

    /**
     * @var string
     */
    private $feed;

    /**
     * @var integer
     */
    private $organizationId;

    /**
     * The values from the 'feeds' bundle configuration node
     * @var array
     */
    private $configuration;

    /**
     * @var string
     */
    private $baseUrl = 'http://marcatoweb.com/xml/';

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var array
     */
    private $validFeedTypes = array(
        self::FEED_TYPE_ARTISTS,
        self::FEED_TYPE_CONTACTS,
        self::FEED_TYPE_PERFORMANCES,
        self::FEED_TYPE_SHOWS,
        self::FEED_TYPE_VENUES,
        self::FEED_TYPE_WORKSHOPS
    );

    /**
     * @param $organizationId
     * @param $configuration
     */
    public function __construct($organizationId, $configuration)
    {
        if (empty($organizationId))
        {
            throw new \RuntimeException('You must pass a valid Marcato organization ID');
        }

        $this->organizationId = $organizationId;
        $this->configuration = $configuration;
    }

    /**
     * @return array
     */
    public function retrieveAll()
    {
        $out = array();

        foreach ($this->validFeedTypes as $feedType)
        {
            // Check to make sure the feed type is enabled in the bundle config
            if ($this->configuration[$feedType])
            {
                $url = $this->buildFeedUrl($feedType);
                $out[$feedType] = $this->downloadXml($url);
            }
        }

        return $out;
    }

    /**
     * @return EntityBodyInterface|string
     */
    public function retrieveArtists()
    {
        if ($this->configuration[static::FEED_TYPE_ARTISTS])
        {
            $url = $this->buildFeedUrl(static::FEED_TYPE_ARTISTS);

            return $this->downloadXml($url);
        }
    }

    /**
     * @return EntityBodyInterface|string
     */
    public function retrieveContacts()
    {
        if ($this->configuration[static::FEED_TYPE_CONTACTS])
        {
            $url = $this->buildFeedUrl(static::FEED_TYPE_CONTACTS);

            return $this->downloadXml($url);
        }
    }

    /**
     * @return EntityBodyInterface|string
     */
    public function retrievePerformances()
    {
        if ($this->configuration[static::FEED_TYPE_PERFORMANCES])
        {
            $url = $this->buildFeedUrl(static::FEED_TYPE_PERFORMANCES);

            return $this->downloadXml($url);
        }
    }


    /**
     * @return EntityBodyInterface|string
     */
    public function retrieveShows()
    {
        if ($this->configuration[static::FEED_TYPE_SHOWS])
        {
            $url = $this->buildFeedUrl(static::FEED_TYPE_SHOWS);

            return $this->downloadXml($url);
        }
    }

    /**
     * @return EntityBodyInterface|string
     */
    public function retrieveVenues()
    {
        if ($this->configuration[static::FEED_TYPE_VENUES])
        {
            $url = $this->buildFeedUrl(static::FEED_TYPE_VENUES);

            return $this->downloadXml($url);
        }
    }

    /**
     * @return EntityBodyInterface|string
     */
    public function retrieveWorkshops()
    {
        if ($this->configuration[static::FEED_TYPE_WORKSHOPS])
        {
            $url = $this->buildFeedUrl(static::FEED_TYPE_WORKSHOPS);

            return $this->downloadXml($url);
        }
    }

    /**
     * Do the dirty work.
     * @param string $url
     * @return EntityBodyInterface|string
     */
    private function downloadXml($url)
    {
        try
        {
            $client = new Client($url);
            $request = $client->createRequest('GET', $url);
            $response = $client->send($request);
            $code = $response->getStatusCode();

            if ($code !== 200)
            {
                throw new BadResponseException(sprintf('Cannot load resource "%s": returned %d with message: "%s"',
                    $url,
                    $code,
                    $response->getReasonPhrase()));
            }

            return $response->getBody(false);
        }
        catch (ClientErrorResponseException $e)
        {
            throw $e;
        }
    }

    /**
     * @param $feedType
     * @return string
     */
    private function buildFeedUrl($feedType)
    {
        return $this->baseUrl . $feedType . '_' . $this->organizationId . '.xml';
    }
}