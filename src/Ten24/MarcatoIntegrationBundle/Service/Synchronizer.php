<?php

namespace Ten24\MarcatoIntegrationBundle\Service;

use Doctrine\ORM\EntityManager;

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
     * @var \Doctrine\Orm\EntityManager
     */
    private $entityManager;

    /**
     * @var array
     */
    private $configuration;

    /**
     * @param Downloader $downloader
     * @param EntityParser $parser
     * @param EntityManager $entityManager
     * @param array $configuration
     */
    public function __construct(Downloader $downloader,
                                EntityParser $parser,
                                EntityManager $entityManager,
                                array $configuration = array())
    {
        $this->downloader = $downloader;
        $this->parser = $parser;
        $this->entityManager = $entityManager;
        $this->configuration = $configuration;
    }

    /**
     * Synchronize all feeds
     */
    public function synchronizeAll()
    {
        // No flush on methods here, just call it once at the end

        if ($this->configuration['artists'])
        {
            $this->synchronizeArtists(false);
        }

        if ($this->configuration['contacts'])
        {
            $this->synchronizeContacts(false);
        }

        if ($this->configuration['shows'])
        {
            $this->synchronizeShows(false);
        }

        if ($this->configuration['venues'])
        {
            $this->synchronizeVenues(false);
        }

        if ($this->configuration['workshops'])
        {
            $this->synchronizeWorkshops(false);
        }

        $this->entityManager->flush();
    }

    /**
     * shortcut
     * @see synchronizeAll
     */
    public function synchronize()
    {
        $this->synchronizeAll();
    }

    /**
     * @param bool $flush
     */
    public function synchronizeArtists($flush = true)
    {
        if ($this->configuration['artists'])
        {
            $xml = $this->downloader->retrieveArtists();

            /** @var \Ten24\MarcatoIntegrationBundle\Entity\Artists $artists */
            $artists = $this->parser->parse(Downloader::FEED_TYPE_ARTISTS, $xml);

            /**
             * @todo this needs to check the current entities and do a diff against the newly parsed, and set the one's not found to un-published (locally)
             */

            /** @var \Ten24\MarcatoIntegrationBundle\Entity\Artist $artist */
            foreach ($artists->getArtists() as $artist)
            {
                $this->entityManager->merge($artist);
            }

            if ($flush)
            {
                $this->entityManager->flush();
            }
        }
    }

    /**
     * @param bool $flush
     */
    public function synchronizeContacts($flush = true)
    {
        if ($this->configuration['contacts'])
        {
            $xml = $this->downloader->retrieveContacts();

            /** @var \Ten24\MarcatoIntegrationBundle\Entity\Contacts $contacts */
            $contacts = $this->parser->parse(Downloader::FEED_TYPE_CONTACTS, $xml);

            /**
             * @todo this needs to check the current entities and do a diff against the newly parsed, and set the one's not found to un-published (locally)
             */

            /** @var \Ten24\MarcatoIntegrationBundle\Entity\Contact $contact */
            foreach ($contacts->getContacts() as $contact)
            {
                $this->entityManager->merge($contact);
            }

            if ($flush)
            {
                $this->entityManager->flush();
            }
        }
    }

    /**
     * @param bool $flush
     */
    public function synchronizeShows($flush = true)
    {
        if ($this->configuration['shows'])
        {
            $xml = $this->downloader->retrieveShows();

            /** @var \Ten24\MarcatoIntegrationBundle\Entity\Shows $shows */
            $shows = $this->parser->parse(Downloader::FEED_TYPE_SHOWS, $xml);

            /**
             * @todo this needs to check the current entities and do a diff against the newly parsed, and set the one's not found to un-published (locally)
             */

            /** @var \Ten24\MarcatoIntegrationBundle\Entity\Show $show */
            foreach ($shows->getShows() as $show)
            {
                $this->entityManager->merge($show);
            }

            if ($flush)
            {
                $this->entityManager->flush();
            }
        }
    }

    /**
     * @param bool $flush
     */
    public function synchronizeVenues($flush = true)
    {
        $xml = $this->downloader->retrieveVenues();

        /** @var \Ten24\MarcatoIntegrationBundle\Entity\Venues $venues */
        $venues = $this->parser->parse(Downloader::FEED_TYPE_VENUES, $xml);

        /**
         * @todo this needs to check the current entities and do a diff against the newly parsed, and set the one's not found to un-published (locally)
         */

        /** @var \Ten24\MarcatoIntegrationBundle\Entity\Venue $venue */
        foreach ($venues->getVenues() as $venue)
        {
            $this->entityManager->merge($venue);
        }

        if ($flush)
        {
            $this->entityManager->flush();
        }
    }

    /**
     * @param bool $flush
     */
    public function synchronizeWorkshops($flush = true)
    {
        if ($this->configuration['workshops'])
        {
            $xml = $this->downloader->retrieveWorkshops();

            /** @var \Ten24\MarcatoIntegrationBundle\Entity\Workshops $workshops */
            $workshops = $this->parser->parse(Downloader::FEED_TYPE_WORKSHOPS, $xml);

            /**
             * @todo this needs to check the current entities and do a diff against the newly parsed, and set the one's not found to un-published (locally)
             */
            // Disable the soft-delete filter to findAll
            $this->entityManager
                ->getFilters()
                ->disable('softdeleteable');

            $persistedEntities = $this->entityManager
                ->getRepository('Ten24MarcatoIntegrationBundle:Workshop')
                ->findAll();

            foreach($persistedEntities as $entity)
            {
                // If the persisted entity is not in the newly parsed ArrayCollection
                // remove the persisted entity (softdeleteable)
                if (!in_array($entity, $workshops->getWorkshops(), true))
                {
                    $this->entityManager->remove($entity);
                }
            }

            /** @var \Ten24\MarcatoIntegrationBundle\Entity\Workshop $workshop */
            foreach ($workshops->getWorkshops() as $workshop)
            {
                $this->entityManager->merge($workshop);
            }

            if ($flush)
            {
                $this->entityManager->flush();
            }
        }
    }
}