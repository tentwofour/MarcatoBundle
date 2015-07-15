<?php

namespace Ten24\MarcatoIntegrationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

/**
 * Artist
 *
 * @ORM\Table(name="ten24_marcato_artists")
 * @ORM\Entity(repositoryClass="Ten24\MarcatoIntegrationBundle\Repository\ArtistRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=true)
 * @Serializer\ExclusionPolicy("none")
 */
class Artist extends AbstractEntity
{
    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Serializer\Type("string")
     */
    private $name;

    /**
     * @ORM\Column(name="biography", type="text", nullable=true)
     * @Serializer\Type("string")
     * @Serializer\SerializedName("bio_public")
     */
    private $biography;

    /**
     * @ORM\Column(name="genre", type="string", length=128, nullable=true)
     * @Serializer\Type("string")
     */
    private $genre;

    /**
     * @ORM\Column(name="homebase", type="string", length=255, nullable=true)
     * @Serializer\Type("string")
     */
    private $homebase;

    /**
     * @ORM\Column(name="web_photo_url", type="string", length=255, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\SerializedName("web_photo_url")
     */
    private $webPhotoUrl;

    /**
     * @ORM\Column(name="web_photo_fingerprint", type="string", length=64, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\SerializedName("web_photo_fingerprint")
     */
    private $webPhotoFingerprint;

    /**
     * @ORM\Column(name="ordering", type="integer", nullable=true)
     * @Serializer\Type("integer")
     * @Serializer\SerializedName("external_id_slug")
     */
    private $ordering;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true, options={"default" = null})
     * @Serializer\Type("DateTime")
     * @Serializer\SerializedName("updated_at")
     */
    private $updatedAt;

    /**
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     * @Serializer\Type("string")
     */
    private $website;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\ManyToMany(targetEntity="Ten24\MarcatoIntegrationBundle\Entity\Website", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="ten24_marcato_artists_websites",
     *      joinColumns={@ORM\JoinColumn(name="artist_id", referencedColumnName="id", nullable=false)},
     *      inverseJoinColumns={@ORM\JoinColumn(name="website_id", referencedColumnName="id", nullable=false)}
     *      )
     * @Serializer\SerializedName("websites")
     * @Serializer\Type("ArrayCollection<Ten24\MarcatoIntegrationBundle\Entity\Website>")
     * @Serializer\XmlList(entry="website", inline=false)
     */
    private $websites;

    /**
     * @ORM\ManyToMany(targetEntity="Ten24\MarcatoIntegrationBundle\Entity\Show", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="ten24_marcato_artists_shows",
     *      joinColumns={@ORM\JoinColumn(name="artist_id", referencedColumnName="id", nullable=false)},
     *      inverseJoinColumns={@ORM\JoinColumn(name="show_id", referencedColumnName="id", nullable=false)}
     *      )
     * @Serializer\Exclude()
     */
    private $shows;

    /**
     * @ORM\ManyToMany(targetEntity="Ten24\MarcatoIntegrationBundle\Entity\Workshop", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="ten24_marcato_artists_workshops",
     *      joinColumns={@ORM\JoinColumn(name="artist_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="workshop_id", referencedColumnName="id")}
     *      )
     * @Serializer\SerializedName("workshops")
     * @Serializer\Type("ArrayCollection<Ten24\MarcatoIntegrationBundle\Entity\Workshop>")
     * @Serializer\XmlList(entry="workshop", inline=false)
     */
    private $workshops;

    /**
     * This field is not included in the artist feed from Marcato, so we exclude it
     * It is included on the shows feed, as an XMLList, where each Performance has an artist_id field
     * @ORM\ManyToMany(targetEntity="Ten24\MarcatoIntegrationBundle\Entity\Performance", mappedBy="artists", cascade={"persist", "merge"})
     * @Serializer\Exclude()
     */
    private $performances;

    /**
     * @ORM\ManyToMany(targetEntity="Ten24\MarcatoIntegrationBundle\Entity\Tag", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="ten24_marcato_artists_tags",
     *      joinColumns={@ORM\JoinColumn(name="artist_id", referencedColumnName="id", nullable=false)},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id", nullable=false)}
     *      )
     * @Serializer\SerializedName("tags")
     * @Serializer\Type("ArrayCollection<Ten24\MarcatoIntegrationBundle\Entity\Tag>")
     * @Serializer\XmlList(entry="tag", inline=false)
     */
    private $tags;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->performances = new ArrayCollection();
        $this->shows = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->workshops = new ArrayCollection();
        $this->websites = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Artist
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * @param mixed $biography
     * @return Artist
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;

        return $this;
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
     * @return Artist
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
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
     * @return Artist
     */
    public function setHomebase($homebase)
    {
        $this->homebase = $homebase;

        return $this;
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
     * @return Artist
     */
    public function setWebPhotoUrl($webPhotoUrl)
    {
        $this->webPhotoUrl = $webPhotoUrl;

        return $this;
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
     * @return Artist
     */
    public function setWebPhotoFingerprint($webPhotoFingerprint)
    {
        $this->webPhotoFingerprint = $webPhotoFingerprint;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrdering()
    {
        return $this->ordering;
    }

    /**
     * @param mixed $ordering
     * @return Artist
     */
    public function setOrdering($ordering)
    {
        $this->ordering = $ordering;

        return $this;
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
     * @return Artist
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return array
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     * @return Artist
     */
    public function setWebsite($website)
    {
        $this->websites = $website;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param \DateTime $deletedAt
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @return ArrayCollection
     */
    public function getWebsites()
    {
        return $this->websites;
    }

    /**
     * @param ArrayCollection $websites
     * @return Artist
     */
    public function setWebsites(ArrayCollection $websites)
    {
        $this->websites->clear();
        $this->websites = $websites;

        return $this;
    }

    /**
     * @param Website $website
     * @return Artist
     */
    public function addWebsite(Website $website)
    {
        if (!$this->websites->contains($website))
        {
            $this->websites->add($website);
        }

        return $this;
    }

    /**
     * @param Website $website
     * @return Artist
     */
    public function removeWebsite(Website $website)
    {
        if ($this->websites->contains($website))
        {
            $this->websites->removeElement($website);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPerformances()
    {
        return $this->performances;
    }

    /**
     * @param ArrayCollection $performances
     * @return Artist
     */
    public function setPerformances(ArrayCollection $performances)
    {
        $this->performances->clear();

        foreach($performances as $performance)
        {
            $this->addPerformance($performance);
        }

        return $this;
    }

    /**
     * @param Performance $performance
     * @return Artist
     */
    public function addPerformance(Performance $performance)
    {
        if (!$this->performances->contains($performance))
        {
            $this->performances->add($performance);
            $performance->addArtist($this);
        }

        return $this;
    }

    /**
     * @param Performance $performance
     * @return Artist
     */
    public function removePerformance(Performance $performance)
    {
        if ($this->performances->contains($performance))
        {
            $this->performances->removeElement($performance);
            $performance->removeArtist($this);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getShows()
    {
        return $this->shows;
    }

    /**
     * @param ArrayCollection $shows
     * @return Artist
     */
    public function setShows(ArrayCollection $shows)
    {
        $this->shows->clear();
        $this->shows = $shows;

        return $this;
    }

    /**
     * @param Show $show
     * @return Artist
     */
    public function addShow(Show $show)
    {
        if (!$this->workshops->contains($show))
        {
            $this->workshops->add($show);
        }

        return $this;
    }

    /**
     * @param Show $show
     * @return Artist
     */
    public function removeShow(Show $show)
    {
        if ($this->workshops->contains($show))
        {
            $this->workshops->removeElement($show);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getWorkshops()
    {
        return $this->workshops;
    }

    /**
     * @param ArrayCollection $workshops
     * @return Artist
     */
    public function setWorkshops(ArrayCollection $workshops)
    {
        $this->workshops->clear();
        $this->workshops = $workshops;

        return $this;
    }

    /**
     * @param Workshop $workshop
     * @return Artist
     */
    public function addWorkshop(Workshop $workshop)
    {
        if (!$this->workshops->contains($workshop))
        {
            $this->workshops->add($workshop);
        }

        return $this;
    }

    /**
     * @param Workshop $workshop
     * @return Artist
     */
    public function removeWorkshop(Workshop $workshop)
    {
        if ($this->workshops->contains($workshop))
        {
            $this->workshops->removeElement($workshop);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param ArrayCollection $tags
     * @return Artist
     */
    public function setTags(ArrayCollection $tags)
    {
        $this->tags->clear();
        $this->tags = $tags;

        return $this;
    }

    /**
     * @param Tag $tag
     * @return Artist
     */
    public function addTag(Tag $tag)
    {
        if (!$this->tags->contains($tag))
        {
            $this->tags->add($tag);
        }

        return $this;
    }

    /**
     * @param Tag $tag
     * @return Artist
     */
    public function removeTag(Tag $tag)
    {
        if ($this->tags->contains($tag))
        {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

    /**
     * Shortcut to find a website by name,
     * as they're stored in an ArrayCollection
     */
    public function getWebsiteByName($name = null)
    {
        if (null !== $name && count($this->websites) > 0)
        {
            foreach($this->websites as $website)
            {
                if ($website->getName() === $name)
                {
                    return $website->getUrl();
                }
            }
        }

        return null;
    }
}