<?php

namespace Ten24\MarcatoIntegrationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

/**
 * Performance
 *
 * @ORM\Table(name="ten24_marcato_performances")
 * @ORM\Entity(repositoryClass="Ten24\MarcatoIntegrationBundle\Repository\PerformanceRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=true)
 * @Serializer\ExclusionPolicy("none")
 */
class Performance extends AbstractEntity
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime", options={"default" = NULL}, nullable=true)
     * @Serializer\SerializedName("start_unix")
     * @Serializer\Type("DateTime<'U'>")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_time", type="datetime", options={"default" = NULL}, nullable=true)
     * @Serializer\SerializedName("start")
     * @Serializer\Type("DateTime<'H:i A'>")
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime", options={"default" = NULL}, nullable=true)
     * @Serializer\SerializedName("end_unix")
     * @Serializer\Type("DateTime<'U'>")
     */
    private $endDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_time", type="datetime", options={"default" = NULL}, nullable=true)
     * @Serializer\SerializedName("end")
     * @Serializer\Type("DateTime<'H:i A'>")
     */
    private $endTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="ordering", type="integer", nullable=true)
     * @Serializer\SerializedName("rank")
     * @Serializer\Type("integer")
     */
    private $ordering;

    /**
     * @Gedmo\Slug(handlers={
     *      @Gedmo\SlugHandler(class="Gedmo\Sluggable\Handler\RelativeSlugHandler", options={
     *          @Gedmo\SlugHandlerOption(name="relationField", value="show"),
     *          @Gedmo\SlugHandlerOption(name="relationSlugField", value="slug"),
     *          @Gedmo\SlugHandlerOption(name="urilize", value=true)
     *      })
     * }, fields={"startDate"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="Ten24\MarcatoIntegrationBundle\Entity\Artist", inversedBy="performances")
     * @ORM\JoinColumn(name="artist_id", referencedColumnName="id", nullable=true, unique=false, onDelete="CASCADE")
     * @Serializer\Exclude()
     */
    private $artist;

    /**
     * @todo hack
     * Temporary field, read from XML, and used to find the artist
     * @Serializer\SerializedName("artist_id")
     * @Serializer\Type("integer")
     */
    private $artistId;

    /**
     * @ORM\ManyToOne(targetEntity="Ten24\MarcatoIntegrationBundle\Entity\Show", inversedBy="performances", cascade={"persist", "merge"})
     * @ORM\JoinColumn(name="show_id", referencedColumnName="id", nullable=false, unique=false, onDelete="CASCADE")
     * @Serializer\SerializedName("show_id")
     * @Serializer\Type("integer")
     */
    private $show;

    /**
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Performance
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
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
     * Set startTime
     *
     * @param \DateTime $startTime
     * @return Performance
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Performance
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
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
     * Set endTime
     *
     * @param \DateTime $endTime
     * @return Performance
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Set ordering
     *
     * @param integer $ordering
     * @return Performance
     */
    public function setOrdering($ordering)
    {
        $this->ordering = $ordering;

        return $this;
    }

    /**
     * Get ordering
     *
     * @return integer 
     */
    public function getOrdering()
    {
        return $this->ordering;
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
     * @return integer
     */
    public function getArtistId()
    {
        return $this->artistId;
    }

    /**
     * @param integer $artistId
     * @return Performance
     */
    public function setArtistId($artistId)
    {
        $this->artistId = $artistId;

        return $this;
    }

    /**
     * @return Artist
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @param Artist $artist
     * @return Performance
     */
    public function setArtist(Artist $artist)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * Set show
     *
     * @param Show $show
     * @return Performance
     */
    public function setShow(Show $show)
    {
        $this->show = $show;

        return $this;
    }

    /**
     * Get show
     *
     * @return Show
     */
    public function getShow()
    {
        return $this->show;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set deletedAt
     *
     * @param $deletedAt
     * @return Performance
     */
    public function setDeletedAt(\DateTime $deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}
