<?php

namespace Ten24\MarcatoIntegrationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

/**
 * Venue
 *
 * @ORM\Table(name="ten24_marcato_venues")
 * @ORM\Entity(repositoryClass="Ten24\MarcatoIntegrationBundle\Repository\VenueRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=true)
 * @Serializer\ExclusionPolicy("none")
 */
class Venue extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Serializer\Type("string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255, nullable=true)
     * @Serializer\Type("string")
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=128, nullable=true)
     * @Serializer\Type("string")
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="province_state", type="string", length=64, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\SerializedName("province_state")
     */
    private $provinceState;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=64, nullable=true)
     * @Serializer\Type("string")
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="postal_code", type="string", length=16, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\SerializedName("postal_code")
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="community", type="string", length=64, nullable=true)
     * @Serializer\Type("string")
     */
    private $community;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="decimal", precision=10, scale=7, nullable=true)
     * @Serializer\Type("double")
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="decimal", precision=10, scale=7, nullable=true)
     * @Serializer\Type("double")
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_url", type="string", length=255, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\SerializedName("photo_url")
     */
    private $photoUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_fingerprint", type="string", length=64, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\SerializedName("photo_fingerprint")
     */
    private $photoFingerprint;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Serializer\Type("DateTime")
     * @Serializer\SerializedName("updated_at")
     */
    private $updatedAt;

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
     * @ORM\ManyToMany(targetEntity="Ten24\MarcatoIntegrationBundle\Entity\Website", cascade={"persist", "merge", "remove"})
     * @ORM\JoinTable(name="ten24_marcato_venues_websites",
     *      joinColumns={@ORM\JoinColumn(name="venue_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="venue_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")}
     *      )
     * @Serializer\SerializedName("websites")
     * @Serializer\Type("ArrayCollection<Ten24\MarcatoIntegrationBundle\Entity\Website>")
     * @Serializer\XmlList(entry="website", inline=false)
     */
    private $websites;

    /**
     * @ORM\ManyToMany(targetEntity="Ten24\MarcatoIntegrationBundle\Entity\Tag", cascade={"persist", "merge", "remove"})
     * @ORM\JoinTable(name="ten24_marcato_venues_tags",
     *      joinColumns={@ORM\JoinColumn(name="venue_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")}
     *      )
     * @Serializer\SerializedName("tags")
     * @Serializer\Type("ArrayCollection<Ten24\MarcatoIntegrationBundle\Entity\Tag>")
     * @Serializer\XmlList(entry="tag", inline=false)
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity="Ten24\MarcatoIntegrationBundle\Entity\Show", cascade={"persist", "merge", "remove"}, mappedBy="venue")
     * @Serializer\Type("ArrayCollection<Ten24\MarcatoIntegrationBundle\Entity\Show>")
     * @Serializer\SerializedName("shows")
     * @Serializer\XmlList(entry="show")
     */
    private $shows;

    /**
     *
     */
    public function __construct()
    {
        $this->shows    = new ArrayCollection();
        $this->tags     = new ArrayCollection();
        $this->websites = new ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Venue
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return Venue
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Venue
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set provinceState
     *
     * @param string $provinceState
     *
     * @return Venue
     */
    public function setProvinceState($provinceState)
    {
        $this->provinceState = $provinceState;

        return $this;
    }

    /**
     * Get provinceState
     *
     * @return string
     */
    public function getProvinceState()
    {
        return $this->provinceState;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Venue
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     *
     * @return Venue
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set community
     *
     * @param string $community
     *
     * @return Venue
     */
    public function setCommunity($community)
    {
        $this->community = $community;

        return $this;
    }

    /**
     * Get community
     *
     * @return string
     */
    public function getCommunity()
    {
        return $this->community;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Venue
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Venue
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set photoUrl
     *
     * @param string $photoUrl
     *
     * @return Venue
     */
    public function setPhotoUrl($photoUrl)
    {
        $this->photoUrl = $photoUrl;

        return $this;
    }

    /**
     * Get photoUrl
     *
     * @return string
     */
    public function getPhotoUrl()
    {
        return $this->photoUrl;
    }

    /**
     * Set photoFingerprint
     *
     * @param string $photoFingerprint
     *
     * @return Venue
     */
    public function setPhotoFingerprint($photoFingerprint)
    {
        $this->photoFingerprint = $photoFingerprint;

        return $this;
    }

    /**
     * Get photoFingerprint
     *
     * @return string
     */
    public function getPhotoFingerprint()
    {
        return $this->photoFingerprint;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Venue
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
     *
     * @return Venue
     */
    public function setWebsites(ArrayCollection $websites)
    {
        $this->websites->clear();
        $this->websites = $websites;

        return $this;
    }

    /**
     * @param Website $website
     */
    public function addWebsite(Website $website)
    {
        if (!$this->websites->contains($website))
        {
            $this->websites->add($website);
        }
    }

    /**
     * @param Website $website
     */
    public function removeWebsite(Website $website)
    {
        if ($this->websites->contains($website))
        {
            $this->websites->removeElement($website);
        }
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
     *
     * @return Venue
     */
    public function setShows(ArrayCollection $shows)
    {
        $this->shows->clear();
        $this->shows = $shows;

        return $this;
    }

    /**
     * @param Show $show
     *
     * @return Venue
     */
    public function addShow(Show $show)
    {
        if (!$this->shows->contains($show))
        {
            $this->shows->add($show);

            $show->setVenue($this);
        }

        return $this;
    }

    /**
     * @param Show $show
     *
     * @return Venue
     */
    public function removeShow(Show $show)
    {
        if ($this->shows->contains($show))
        {
            $this->shows->removeElement($show);
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
     *
     * @return Venue
     */
    public function setTags(ArrayCollection $tags)
    {
        $this->tags->clear();
        $this->tags = $tags;

        return $this;
    }

    /**
     * @param Tag $tag
     *
     * @return Venue
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
     *
     * @return Venue
     */
    public function removeTag(Tag $tag)
    {
        if ($this->tags->contains($tag))
        {
            $this->tags->removeElement($tag);
        }

        return $this;
    }
}
