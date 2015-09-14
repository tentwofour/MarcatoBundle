<?php

namespace Ten24\Tests\MarcatoIntegrationBundle\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class DownloaderTest
 *
 * @package Ten24\Tests\MarcatoIntegrationBundle\Service
 * @todo    - change bundle configuration to see if download for each feed type passes when that feed type is disabled in the bundle config
 * @todo    - this shouldn't actually download anything, it should mock the data/connection...
 */
class DownloaderTest extends KernelTestCase
{
    /**
     * @var \Ten24\MarcatoIntegrationBundle\Service\Downloader
     */
    private $downloader;

    /**
     * Setup before each test
     */
    public function setUp()
    {
        $kernel = $this->createKernel();
        $kernel->boot();

        $this->downloader = $kernel->getContainer()
                                   ->get('ten24_marcato_integration.downloader');
    }

    public function testRetrieveArtists()
    {
        /** @var \DOMDocument $doc */
        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadXML($this->downloader->retrieveArtists());

        $this->assertNotEmpty($doc, 'XML string is not empty');
    }

    public function testRetrieveContacts()
    {

        /** @var \DOMDocument $doc */
        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadXML($this->downloader->retrieveContacts());

        $this->assertNotEmpty($doc, 'XML string is not empty');

    }

    public function testRetrieveShows()
    {
        /** @var \DOMDocument $doc */
        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadXML($this->downloader->retrieveShows());

        $this->assertNotEmpty($doc, 'XML string is not empty');

    }

    public function testRetrieveVenues()
    {
        /** @var \DOMDocument $doc */
        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadXML($this->downloader->retrieveVenues());

        $this->assertNotEmpty($doc, 'XML string is not empty');

    }

    public function testRetrieveWorkshops()
    {
        /** @var \DOMDocument $doc */
        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadXML($this->downloader->retrieveWorkshops());

        $this->assertNotEmpty($doc, 'XML string is not empty');
    }
}