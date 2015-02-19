<?php

namespace Ten24\Tests\MarcatoIntegrationBundle\Service;

use Doctrine\Common\Cache\ArrayCache;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Ten24\MarcatoIntegrationBundle\Service\CacheProvider;

/**
 * Class CacheProviderTest
 * @package Ten24\Tests\MarcatoIntegrationBundle\Service
 */
class CacheProviderTest extends KernelTestCase
{
    /**
     * @var \Ten24\MarcatoIntegrationBundle\Service\CacheProvider
     */
    private $cacheProvider;

    /**
     * Setup before each test
     */
    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $this->cacheProvider = $kernel->getContainer()
                                     ->get('ten24_marcato_integration.cache_provider.default');
    }

    public function testSetGetArtists()
    {
        // Parsed array from XML
        $parsed = include_once(__DIR__.'/../Fixtures/Parsed/artists.parsed.php');

        // Set cache with sample parsed data
        $this->assertTrue($this->cacheProvider->setArtists($parsed));

        // Get cache, should return sample cached data
        $this->assertEquals($parsed, $this->cacheProvider->getArtists());
    }

    public function testSetGetContacts()
    {
        // Parsed array from XML
        $parsed = include_once(__DIR__.'/../Fixtures/Parsed/contacts.parsed.php');

        // Set cache with sample parsed data
        $this->assertTrue($this->cacheProvider->setContacts($parsed));

        // Get cache, should return sample cached data
        $this->assertEquals($parsed, $this->cacheProvider->getContacts());
    }

    public function testSetGetShows()
    {
        // Parsed array from XML
        $parsed = include_once(__DIR__.'/../Fixtures/Parsed/shows.parsed.php');

        // Set cache with sample parsed data
        $this->assertTrue($this->cacheProvider->setShows($parsed));

        // Get cache, should return sample cached data
        $this->assertEquals($parsed, $this->cacheProvider->getShows());
    }

    public function testSetGetVenues()
    {
        // Parsed array from XML
        $parsed = include_once(__DIR__.'/../Fixtures/Parsed/venues.parsed.php');

        // Set cache with sample parsed data
        $this->assertTrue($this->cacheProvider->setVenues($parsed));

        // Get cache, should return sample cached data
        $this->assertEquals($parsed, $this->cacheProvider->getVenues());
    }

    public function testSetGetWorkshops()
    {
        // Parsed array from XML
        $parsed = include_once(__DIR__.'/../Fixtures/Parsed/workshops.parsed.php');

        // Set cache with sample parsed data
        $this->assertTrue($this->cacheProvider->setWorkshops($parsed));

        // Get cache, should return sample cached data
        $this->assertEquals($parsed, $this->cacheProvider->getWorkshops());
    }


}