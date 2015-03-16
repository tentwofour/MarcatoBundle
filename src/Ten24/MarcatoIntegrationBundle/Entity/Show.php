<?php

namespace Ten24\MarcatoIntegrationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

/**
 * Show
 *
 * @ORM\Table(name="ten24_marcato_shows")
 * @ORM\Entity(repositoryClass="Ten24\MarcatoIntegrationBundle\Repository\ShowRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=true)
 * @Serializer\ExclusionPolicy("none")
 */
class Show extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Serializer\Type("string")
     * @Serializer\SerializedName("name")
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     * @Serializer\Type("DateTime<'U'>")
     * @Serializer\SerializedName("date_unix")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Serializer\Type("string")
     * @Serializer\SerializedName("description_public")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="string", length=255, nullable=true)
     * @Serializer\Type("string")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="ticket_info", type="string", length=255, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\SerializedName("ticket_info")
     */
    private $ticketInfo;

    /**
     * @var string
     *
     * @ORM\Column(name="ticket_link", type="string", length=255, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\SerializedName("ticket_link")
     */
    private $ticketLink;

    /**
     * @var string
     *
     * @ORM\Column(name="ticket_status", type="string", length=128, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\SerializedName("ticket_status")
     */
    private $ticketStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="seating", type="string", length=128, nullable=true)
     * @Serializer\Type("string")
     */
    private $seating;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_time", type="datetime", nullable=true, options={"default" = NULL})
     * @Serializer\Type("DateTime<'U'>")
     * @Serializer\SerializedName("start_time_unix")
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_time", type="datetime", nullable=true)
     * @Serializer\Type("DateTime<'U'>")
     * @Serializer\SerializedName("end_time_unix")
     */
    private $endTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="door_time", type="datetime", nullable=true)
     * @Serializer\Type("DateTime<'U'>")
     * @Serializer\SerializedName("door_time_unix")
     */
    private $doorTime;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_link", type="string", length=255, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\SerializedName("facebook_link")
     */
    private $facebookLink;

    /**
     * @var string
     *
     * @ORM\Column(name="poster_url", type="string", length=255, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\SerializedName("poster_url")
     */
    private $posterUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="poster_fingerprint", type="string", length=128, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\SerializedName("poster_fingerprint")
     */
    private $posterFingerprint;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetimetz", nullable=true)
     * @Serializer\Type("DateTime")
     * @Serializer\SerializedName("updated_at")
     */
    private $updatedAt;

    /**
     * @Gedmo\Slug(fields={"date", "name"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Ten24\MarcatoIntegrationBundle\Entity\Venue", cascade={"persist", "merge"})
     * @ORM\JoinColumn(name="venue_id", referencedColumnName="id")
     * @Serializer\Type("Ten24\MarcatoIntegrationBundle\Entity\Venue")
     * @Serializer\SerializedName("venue")
     */
    private $venue;

    /**
     * @ORM\ManyToMany(targetEntity="Ten24\MarcatoIntegrationBundle\Entity\Tag", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="ten24_marcato_shows_tags",
     *      joinColumns={@ORM\JoinColumn(name="show_id", referencedColumnName="id", nullable=false)},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id", unique=true, nullable=false)}
     *      )
     * @Serializer\SerializedName("categories")
     * @Serializer\Type("ArrayCollection<Ten24\MarcatoIntegrationBundle\Entity\Tag>")
     * @Serializer\XmlList(entry="category", inline=false)
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity="Ten24\MarcatoIntegrationBundle\Entity\Performance", mappedBy="show", cascade={"persist", "merge"})
     * @Serializer\Type("ArrayCollection<Ten24\MarcatoIntegrationBundle\Entity\Performance>")
     * @Serializer\SerializedName("performances")
     * @Serializer\XmlList(entry="performance", inline=false)
     */
    private $performances;

    /**
     *
     */
    public function __construct()
    {
        $this->performances = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Show
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
     * Set date
     *
     * @param \DateTime $date
     * @return Show
     */
    public function setDate($date)
    {
        $this->date = new \DateTime("@$date");

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Show
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Show
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set ticketInfo
     *
     * @param string $ticketInfo
     * @return Show
     */
    public function setTicketInfo($ticketInfo)
    {
        $this->ticketInfo = $ticketInfo;

        return $this;
    }

    /**
     * Get ticketInfo
     *
     * @return string
     */
    public function getTicketInfo()
    {
        return $this->ticketInfo;
    }

    /**
     * Set ticketLink
     *
     * @param string $ticketLink
     * @return Show
     */
    public function setTicketLink($ticketLink)
    {
        $this->ticketLink = $ticketLink;

        return $this;
    }

    /**
     * Get ticketLink
     *
     * @return string
     */
    public function getTicketLink()
    {
        return $this->ticketLink;
    }

    /**
     * Set ticketStatus
     *
     * @param string $ticketStatus
     * @return Show
     */
    public function setTicketStatus($ticketStatus)
    {
        $this->ticketStatus = $ticketStatus;

        return $this;
    }

    /**
     * Get ticketStatus
     *
     * @return string
     */
    public function getTicketStatus()
    {
        return $this->ticketStatus;
    }

    /**
     * Set seating
     *
     * @param string $seating
     * @return Show
     */
    public function setSeating($seating)
    {
        $this->seating = $seating;

        return $this;
    }

    /**
     * Get seating
     *
     * @return string
     */
    public function getSeating()
    {
        return $this->seating;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     * @return Show
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     * @return Show
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set doorTime
     *
     * @param \DateTime $doorTime
     * @return Show
     */
    public function setDoorTime($doorTime)
    {
        $this->doorTime = $doorTime;

        return $this;
    }

    /**
     * Get doorTime
     *
     * @return \DateTime
     */
    public function getDoorTime()
    {
        return $this->doorTime;
    }

    /**
     * Set facebookLink
     *
     * @param string $facebookLink
     * @return Show
     */
    public function setFacebookLink($facebookLink)
    {
        $this->facebookLink = $facebookLink;

        return $this;
    }

    /**
     * Get facebookLink
     *
     * @return string
     */
    public function getFacebookLink()
    {
        return $this->facebookLink;
    }

    /**
     * Set posterUrl
     *
     * @param string $posterUrl
     * @return Show
     */
    public function setPosterUrl($posterUrl)
    {
        $this->posterUrl = $posterUrl;

        return $this;
    }

    /**
     * Get posterUrl
     *
     * @return string
     */
    public function getPosterUrl()
    {
        return $this->posterUrl;
    }

    /**
     * Set posterFingerprint
     *
     * @param string $posterFingerprint
     * @return Show
     */
    public function setPosterFingerprint($posterFingerprint)
    {
        $this->posterFingerprint = $posterFingerprint;

        return $this;
    }

    /**
     * Get posterFingerprint
     *
     * @return string
     */
    public function getPosterFingerprint()
    {
        return $this->posterFingerprint;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Show
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
     * @param Venue $venue
     * @return Show
     */
    public function setVenue(Venue $venue)
    {
        $this->venue = $venue;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVenue()
    {
        return $this->venue;
    }

    /**
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param $tags
     * @return Show
     */
    public function setTags(ArrayCollection $tags)
    {
        $this->tags->clear();
        $this->tags = $tags;

        return $this;
    }

    /**
     * @param Tag $tag
     * @return Show
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
     * @return Show
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
     * @return ArrayCollection
     */
    public function getPerformances()
    {
        return $this->performances;
    }

    /**
     * @param ArrayCollection $performances
     * @return Show
     */
    public function setPerformances(ArrayCollection $performances)
    {
        $this->performances->clear();
        $this->performances = $performances;

        return $this;
    }

    /**
     * @param Performance $performance
     * @return Show
     */
    public function addPerformance(Performance $performance)
    {
        // Sometimes, Marcato puts an empty <performances type="array">
        // This check should be moved to a custom deserializer handler
        if (!$this->performances->contains($performance))
        {
            $this->performances->add($performance);
        }

        return $this;
    }

    /**
     * @param Performance $performance
     * @return Show
     */
    public function removePerformance(Performance $performance)
    {
        if ($this->performances->contains($performance))
        {
            $this->performances->removeElement($performance);
        }

        return $this;
    }
}
