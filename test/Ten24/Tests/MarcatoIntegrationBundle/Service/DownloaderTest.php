<?php

namespace Ten24\Tests\MarcatoIntegrationBundle\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class DownloaderTest
 * @package Ten24\Tests\MarcatoIntegrationBundle\Service
 * @todo - change bundle configuration to see if download for each feed type passes when that feed type is disabled in the bundle config
 * @todo - this shouldn't actually download anything, it should mock the data/connection...
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
        /** @var \DOMDocument $expected */
        $expected = $this->getFixture('artists');

        /** @var \DOMDocument $actual */
        $actual = new \DOMDocument('1.0', 'utf-8');
        $actual->loadXML($this->downloader->retrieveArtists());

        $this->assertNotEmpty($actual, 'XML string is not empty');
        $this->assertEqualXMLStructure(
            $expected->firstChild,
            $actual->firstChild,
            true,
            'Downloaded XML feed structure matches fixture file structure.');
    }

    public function testRetrieveContacts()
    {
        /** @var \DOMDocument $expected */
        $expected = $this->getFixture('contacts');

        /** @var \DOMDocument $actual */
        $actual = new \DOMDocument('1.0', 'utf-8');
        $actual->loadXML($this->downloader->retrieveContacts());

        $this->assertNotEmpty($actual, 'XML string is not empty');
        $this->assertEqualXMLStructure(
            $expected->firstChild,
            $actual->firstChild,
            true,
            'Downloaded XML feed structure matches fixture file structure.');
    }

    public function testRetrieveShows()
    {
        /** @var \DOMDocument $expected */
        $expected = $this->getFixture('shows');

        /** @var \DOMDocument $actual */
        $actual = new \DOMDocument('1.0', 'utf-8');
        $actual->loadXML($this->downloader->retrieveShows());

        $this->assertNotEmpty($actual, 'XML string is not empty');
        $this->assertEqualXMLStructure(
            $expected->firstChild,
            $actual->firstChild,
            true,
            'Downloaded XML feed structure matches fixture file structure.');
    }

    public function testRetrieveVenues()
    {
        /** @var \DOMDocument $expected */
        $expected = $this->getFixture('venues');

        /** @var \DOMDocument $actual */
        $actual = new \DOMDocument('1.0', 'utf-8');
        $actual->loadXML($this->downloader->retrieveVenues());

        $this->assertNotEmpty($actual, 'XML string is not empty');
        $this->assertEqualXMLStructure(
            $expected->firstChild,
            $actual->firstChild,
            true,
            'Downloaded XML feed structure matches fixture file structure.');
    }

    public function testRetrieveWorkshops()
    {
        /** @var \DOMDocument $expected */
        $expected = $this->getFixture('workshops');

        /** @var \DOMDocument $actual */
        $actual = new \DOMDocument('1.0', 'utf-8');
        $actual->loadXML($this->downloader->retrieveWorkshops());

        $this->assertNotEmpty($actual, 'XML string is not empty');
        $this->assertEqualXMLStructure(
            $expected->firstChild,
            $actual->firstChild,
            true,
            'Downloaded XML feed structure matches fixture file structure.');
    }

    private function getFixture($type = '')
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->load(__DIR__.'/../Fixtures/Feed/'.$type.'.xml');
        return $doc;
    }

}