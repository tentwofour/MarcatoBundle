<?php

namespace Ten24\Tests\MarcatoIntegrationBundle\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class ArrayParserTest
 * @package Ten24\Tests\MarcatoIntegrationBundle\Service
 */
class ArrayParserTest extends KernelTestCase
{
    /**
     * @var \Ten24\MarcatoIntegrationBundle\Service\ArrayParser
     */
    private $parser;

    /**
     * Setup before each test
     */
    public function setUp()
    {
        $kernel = $this->createKernel();
        $kernel->boot();

        $this->parser = $kernel->getContainer()
                               ->get('ten24_marcato_integration.parser.array');
    }

    public function testParseArtists()
    {
        $xml = $this->getFixture('artists');
        $parsed = $this->parser->parse($xml);
        $this->assertEquals('array', gettype($parsed));
        $this->assertArrayHasKey('@type', $parsed);
        $this->assertEquals('array', $parsed['@type']);
        $this->assertArrayHasKey('artist', $parsed);
        $this->assertGreaterThan(1, count($parsed['artist']));
        $this->assertEquals(
            array(
                'bio_limited',
                'bio_limited_alternate',
                'bio_public',
                'external_id_slug',
                'genre',
                'homebase',
                'homebase_alternate',
                'id',
                'name',
                'press_highlights',
                'secondary_language_bio',
                'updated_at',
                'photo_url',
                'photo_url_root',
                'photo_fingerprint',
                'web_photo_url',
                'web_photo_url_root',
                'web_photo_fingerprint',
                'website',
                'websites',
                'categories',
                'artist_types',
                'contacts',
                'custom-fields',
                'workshops',
                'shows',
            ),
            array_keys($parsed['artist'][0])
        );
    }

    public function testParseContacts()
    {
        $xml = $this->getFixture('contacts');
        $parsed = $this->parser->parse($xml);
        $this->assertEquals('array', gettype($parsed));
        $this->assertArrayHasKey('@type', $parsed);
        $this->assertEquals('array', $parsed['@type']);
        $this->assertArrayHasKey('contact', $parsed);
        $this->assertEquals('array', gettype($parsed['contact']));
        $this->assertEquals(
            array(
                'bio',
                'company',
                'industry',
                'name',
                'position',
                'updated_at',
                'photo_url',
                'photo_url_root',
                'photo_fingerprint',
                'email',
                'websites',
                'categories',
                'contact_roles',
                'custom-fields',
            ),
            array_keys($parsed['contact'])
        );
    }

    public function testParseShows()
    {
        $xml = $this->getFixture('shows');
        $parsed = $this->parser->parse($xml);
        $this->assertEquals('array', gettype($parsed));
        $this->assertArrayHasKey('@type', $parsed);
        $this->assertEquals('array', $parsed['@type']);
        $this->assertArrayHasKey('show', $parsed);
        $this->assertGreaterThan(1, count($parsed['show']));
        //die(implode("','", array_keys($parsed['show'][0])));
        $this->assertEquals(
            array(
                'date',
                'description_limited',
                'description_public',
                'description_web',
                'description_web_alternate',
                'id',
                'name',
                'price',
                'ticket_info',
                'ticket_link',
                'updated_at',
                'venue_name',
                'formatted_date',
                'formatted_start_time',
                'formatted_end_time',
                'formatted_door_time',
                'event_contact_summary',
                'hosting_organization_title',
                'facebook_link',
                'poster_url',
                'poster_url_root',
                'poster_fingerprint',
                'seating',
                'ticket_status',
                'date_unix',
                'start_time_unix',
                'end_time_unix',
                'door_time_unix',
                'categories',
                'show_types',
                'nil-classes',
                'contacts',
                'custom-fields'
            ),
            array_keys($parsed['show'][0])
        );
    }

    public function testParseVenues()
    {
        $xml = $this->getFixture('venues');
        $parsed = $this->parser->parse($xml);
        $this->assertEquals('array', gettype($parsed));
        $this->assertArrayHasKey('@type', $parsed);
        $this->assertEquals('array', $parsed['@type']);
        $this->assertArrayHasKey('venue', $parsed);
        $this->assertGreaterThan(1, count($parsed['venue']));
        $this->assertEquals(
            array(
                'community',
                'description',
                'description_alternate',
                'directions',
                'directions_alternate',
                'id',
                'name',
                'updated_at',
                'photo_url',
                'photo_url_root',
                'photo_fingerprint',
                'street',
                'city',
                'province_state',
                'country',
                'postal_code',
                'primary_phone_number',
                'longitude',
                'latitude',
                'google_maps_link',
                'websites',
                'categories',
                'contacts',
                'custom-fields',
                'workshops',
                'shows'
            ),
            array_keys($parsed['venue'][0])
        );
    }

    public function testParseWorkshops()
    {
        $xml = $this->getFixture('workshops');
        $parsed = $this->parser->parse($xml);
        $this->assertEquals('array', gettype($parsed));
        $this->assertArrayHasKey('@type', $parsed);
        $this->assertEquals('array', $parsed['@type']);
        $this->assertArrayHasKey('workshop', $parsed);
        $this->assertGreaterThan(1, count($parsed['workshop']));
        $this->assertEquals(
            array(
                'date',
                'description_limited',
                'description_public',
                'description_web',
                'description_web_alternate',
                'id',
                'name',
                'price',
                'ticket_info',
                'ticket_link',
                'updated_at',
                'venue_name',
                'formatted_date',
                'formatted_start_time',
                'formatted_end_time',
                'formatted_door_time',
                'event_contact_summary',
                'event_contact_name',
                'event_contact_email',
                'event_contact_phone',
                'hosting_organization_title',
                'promoters',
                'copromoters',
                'facebook_link',
                'poster_url',
                'poster_url_root',
                'poster_fingerprint',
                'seating',
                'ticket_status',
                'date_unix',
                'start_time_unix',
                'end_time_unix',
                'door_time_unix',
                'workshop_types',
                'categories',
                'presentations',
                'contacts',
                'custom-fields'
            ),
            array_keys($parsed['workshop'][0])
        );
    }

    private function getFixture($type = '')
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->load(__DIR__ . '/../Fixtures/Feed/' . $type . '.xml');

        return $doc->saveXML();
    }
}