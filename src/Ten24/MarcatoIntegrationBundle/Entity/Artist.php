<?php

namespace Ten24\MarcatoIntegrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Artist
 * @package Ten24\MarcatoIntegrationBundle\Entity
 * @todo
 */
class Artist
{
    /**
     * @ORM\Id()
     */
    private $id;

    /**
     * @ORM\Column(name="marcato_id", type="integer")
     */
    private $marcatoId;

    /**
     * @ORM\Column(name="bio_public", type="text")
     */
    private $bioPublic;

    /**
     * @ORM\Column(name="genre", type="string", length=128)
     */
    private $genre;

    /**
     * @ORM\Column(name="bio_limited", type="text")
     */
    private $bioLimited;

    /**
     * @ORM\Column(name="homebase", type="string", length=255)
     */
    private $homebase;

    /**
     * @ORM\Column(name="web_photo_url", type="string", length=255)
     */
    private $webPhotoUrl;

    /**
     * @ORM\Column(name="web_photo_url_root", type="string", length=255)
     */
    private $webPhotoUrlRoot;

    /**
     * @ORM\Column(name="web_photo_fingerprint", type="string", length=255)
     */
    private $webPhotoFingerprint;

    /**
     * @ORM\Column(name="photo_url", type="string", length=255)
     */
    private $photoUrl;

    /**
     * @ORM\Column(name="photo_url_root", type="string", length=255)
     */
    private $photoUrlRoot;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var array
     */
    private $websites;

    /**
     * @var array
     */
    private $customFields;

    /**
     * ManyToOne
     */
    private $shows;

    /**
     * ManyToOne
     */
    private $workshops;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getMarcatoId()
    {
        return $this->marcatoId;
    }

    /**
     * @param mixed $marcatoId
     */
    public function setMarcatoId($marcatoId)
    {
        $this->marcatoId = $marcatoId;
    }

    /**
     * @return mixed
     */
    public function getBioPublic()
    {
        return $this->bioPublic;
    }

    /**
     * @param mixed $bioPublic
     */
    public function setBioPublic($bioPublic)
    {
        $this->bioPublic = $bioPublic;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param mixed $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return mixed
     */
    public function getBioLimited()
    {
        return $this->bioLimited;
    }

    /**
     * @param mixed $bioLimited
     */
    public function setBioLimited($bioLimited)
    {
        $this->bioLimited = $bioLimited;
    }

    /**
     * @return mixed
     */
    public function getHomebase()
    {
        return $this->homebase;
    }

    /**
     * @param mixed $homebase
     */
    public function setHomebase($homebase)
    {
        $this->homebase = $homebase;
    }

    /**
     * @return mixed
     */
    public function getWebPhotoUrl()
    {
        return $this->webPhotoUrl;
    }

    /**
     * @param mixed $webPhotoUrl
     */
    public function setWebPhotoUrl($webPhotoUrl)
    {
        $this->webPhotoUrl = $webPhotoUrl;
    }

    /**
     * @return mixed
     */
    public function getWebPhotoUrlRoot()
    {
        return $this->webPhotoUrlRoot;
    }

    /**
     * @param mixed $webPhotoUrlRoot
     */
    public function setWebPhotoUrlRoot($webPhotoUrlRoot)
    {
        $this->webPhotoUrlRoot = $webPhotoUrlRoot;
    }

    /**
     * @return mixed
     */
    public function getWebPhotoFingerprint()
    {
        return $this->webPhotoFingerprint;
    }

    /**
     * @param mixed $webPhotoFingerprint
     */
    public function setWebPhotoFingerprint($webPhotoFingerprint)
    {
        $this->webPhotoFingerprint = $webPhotoFingerprint;
    }

    /**
     * @return mixed
     */
    public function getPhotoUrl()
    {
        return $this->photoUrl;
    }

    /**
     * @param mixed $photoUrl
     */
    public function setPhotoUrl($photoUrl)
    {
        $this->photoUrl = $photoUrl;
    }

    /**
     * @return mixed
     */
    public function getPhotoUrlRoot()
    {
        return $this->photoUrlRoot;
    }

    /**
     * @param mixed $photoUrlRoot
     */
    public function setPhotoUrlRoot($photoUrlRoot)
    {
        $this->photoUrlRoot = $photoUrlRoot;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return array
     */
    public function getWebsites()
    {
        return $this->websites;
    }

    /**
     * @param array $websites
     */
    public function setWebsites($websites)
    {
        $this->websites = $websites;
    }

    /**
     * @return array
     */
    public function getCustomFields()
    {
        return $this->customFields;
    }

    /**
     * @param array $customFields
     */
    public function setCustomFields($customFields)
    {
        $this->customFields = $customFields;
    }

    /**
     * @return mixed
     */
    public function getShows()
    {
        return $this->shows;
    }

    /**
     * @param mixed $shows
     */
    public function setShows($shows)
    {
        $this->shows = $shows;
    }

    /**
     * @return mixed
     */
    public function getWorkshops()
    {
        return $this->workshops;
    }

    /**
     * @param mixed $workshops
     */
    public function setWorkshops($workshops)
    {
        $this->workshops = $workshops;
    }


}