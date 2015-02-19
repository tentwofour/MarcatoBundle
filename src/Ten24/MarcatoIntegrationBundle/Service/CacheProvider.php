<?php

namespace Ten24\MarcatoIntegrationBundle\Service;

use Doctrine\Common\Cache\Cache;

class CacheProvider
{
    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var integer
     */
    private $lifetime;

    public function __construct(Cache $cache = null, $lifetime = 0)
    {
        //die(print_r(get_class_methods($cache)));
        $this->cache = $cache;
        $this->cache->setNamespace('ten24_marcato_integration');
        $this->lifetime = $lifetime;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function setArtists(array $data = array())
    {
        return $this->cache(Downloader::FEED_TYPE_ARTISTS, $data);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function setContacts(array $data = array())
    {
        return $this->cache(Downloader::FEED_TYPE_CONTACTS, $data);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function setShows(array $data = array())
    {
        return $this->cache(Downloader::FEED_TYPE_SHOWS, $data);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function setVenues(array $data = array())
    {
        return $this->cache(Downloader::FEED_TYPE_VENUES, $data);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function setWorkshops(array $data = array())
    {
        return $this->cache(Downloader::FEED_TYPE_WORKSHOPS, $data);
    }

    /**
     * @return bool
     */
    public function deleteAll()
    {
        $artists = $this->deleteArtists();
        $contacts = $this->deleteContacts();
        $shows = $this->deleteShows();
        $venues = $this->deleteVenues();
        $workshops = $this->deleteWorkshops();

        return ($artists && $contacts && $shows && $venues && $workshops);
    }

    /**
     * @return bool
     */
    public function deleteArtists()
    {
        return $this->cache->delete(Downloader::FEED_TYPE_ARTISTS);
    }

    /**
     * @return bool
     */
    public function deleteContacts()
    {
        return $this->cache->delete(Downloader::FEED_TYPE_CONTACTS);
    }

    /**
     * @return bool
     */
    public function deleteShows()
    {
        return $this->cache->delete(Downloader::FEED_TYPE_SHOWS);
    }

    /**
     * @return bool
     */
    public function deleteVenues()
    {
        return $this->cache->delete(Downloader::FEED_TYPE_VENUES);
    }

    /**
     * @return bool
     */
    public function deleteWorkshops()
    {
        return $this->cache->delete(Downloader::FEED_TYPE_WORKSHOPS);
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return array(
            Downloader::FEED_TYPE_ARTISTS   => $this->getArtists(),
            Downloader::FEED_TYPE_CONTACTS  => $this->getContacts(),
            Downloader::FEED_TYPE_SHOWS     => $this->getShows(),
            Downloader::FEED_TYPE_VENUES    => $this->getVenues(),
            Downloader::FEED_TYPE_WORKSHOPS => $this->getWorkshops(),
        );
    }

    /**
     * @return mixed
     */
    public function getArtists()
    {
        return $this->cache->fetch(Downloader::FEED_TYPE_ARTISTS);
    }

    /**
     * @return mixed
     */
    public function getContacts()
    {
        return $this->cache->fetch(Downloader::FEED_TYPE_CONTACTS);
    }

    /**
     * @return mixed
     */
    public function getShows()
    {
        return $this->cache->fetch(Downloader::FEED_TYPE_SHOWS);
    }

    /**
     * @return mixed
     */
    public function getVenues()
    {
        return $this->cache->fetch(Downloader::FEED_TYPE_VENUES);
    }

    /**
     * @return mixed
     */
    public function getWorkshops()
    {
        return $this->cache->fetch(Downloader::FEED_TYPE_WORKSHOPS);
    }

    /**
     * @param null $feedType
     * @param $data
     * @return bool
     */
    private function cache($feedType = null, array $data = array())
    {
        if (null === $feedType)
        {
            throw new \InvalidArgumentException('You must pass a valid feed type, one of Downloader::FEED_TYPE_XXX');
        }

        if (null === $data || count($data) < 0)
        {
            throw new \InvalidArgumentException('The passed data is not an array, or an empty array.');
        }

        return $this->cache->save($feedType, $data, $this->lifetime);
    }
}