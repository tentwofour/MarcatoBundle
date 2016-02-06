<?php

namespace Ten24\MarcatoIntegrationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

/**
 * Performance
 *
 * This entity cannot extend our BaseMarcatoEntity:
 *  - A Performance can have multiple artists, under one unique id ($marcatoId)
 *  - The feed for Shows outputs all performances, even if they have the same id ($marcatoId)
 *
 * @ORM\Table(name="ten24_marcato_performances")
 * @ORM\Entity(repositoryClass="Ten24\MarcatoIntegrationBundle\Repository\PerformanceRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=true)
 * @Serializer\ExclusionPolicy("none")
 */
class Performance extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=true)
     * @Serializer\SerializedName("performance_type")
     * @Serializer\Type("string")
     */
    private $type;

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
     * @ORM\Column(name="end_date", type="datetime", options={"default" = NULL}, nullable=true)
     * @Serializer\SerializedName("end_unix")
     * @Serializer\Type("DateTime<'U'>")
     */
    private $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Serializer\SerializedName("description")
     * @Serializer\Type("string")
     */
    private $description;

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
     *          @Gedmo\SlugHandlerOption(name="urilize", value=true),
     *          @Gedmo\SlugHandlerOption(name="separator", value="-")
     *      })
     * }, updatable=true, fields={"type", "description"}, dateFormat="Y-m-d-H-i-s", unique=true)
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity="Ten24\MarcatoIntegrationBundle\Entity\Artist", inversedBy="performances", cascade={"persist", "merge"})
     * @ORM\JoinTable(
     *   name="ten24_marcato_performances_artists",
     *   joinColumns={
     *      @ORM\JoinColumn(name="performance_id", referencedColumnName="id", unique=false, nullable=false)
     * },
     *   inverseJoinColumns={
     *      @ORM\JoinColumn(name="artist_id", referencedColumnName="id", unique=false, nullable=false)
     * }
     * )
     * @Serializer\Exclude()
     */
    private $artists;

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
     * @Serializer\Type("Ten24\MarcatoIntegrationBundle\Entity\Show")
     * @Serializer\SerializedName("show_id")
     */
    private $show;

    /**
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * constructor, initializes collections
     */
    public function __construct()
    {
        $this->artists = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Performance
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
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
     * Set endDate
     *
     * @param \DateTime $endDate
     *
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Performance
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Set ordering
     *
     * @param integer $ordering
     *
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
     *
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
    public function getArtists()
    {
        //$this->ensureArtistsArrayCollection();

        return $this->artists;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $artists
     *
     * @return \Ten24\MarcatoIntegrationBundle\Entity\Performance
     */
    public function setArtists(ArrayCollection $artists)
    {
        $this->ensureArtistsArrayCollection();

        $this->artists->clear();

        foreach ($artists as $artist)
        {
            $this->addArtist($artist);
        }

        return $this;
    }

    /**
     * @param \Ten24\MarcatoIntegrationBundle\Entity\Artist $artist
     */
    public function addArtist(Artist $artist)
    {
        $this->ensureArtistsArrayCollection();

        if (!$this->artists->contains($artist))
        {
            $this->artists->add($artist);
        }
    }

    /**
     * @param \Ten24\MarcatoIntegrationBundle\Entity\Artist $artist
     */
    public function removeArtist(Artist $artist)
    {
        $this->ensureArtistsArrayCollection();

        if ($this->artists->contains($artist))
        {
            $this->artists->removeElement($artist);
        }
    }

    /**
     * Set show
     *
     * @param Show $show
     *
     * @return Performance
     */
    public function setShow($show)
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
     *
     * @return Performance
     */
    public function setDeletedAt(\DateTime $deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Because JMSSerializer doesn't instantiate our entity when deserializing from the Shows feed...
     */
    public function ensureArtistsArrayCollection()
    {
        if (!$this->artists instanceof ArrayCollection)
        {
            $this->artists = new ArrayCollection();
        }
    }

    /**
     * Shortcut method to get all artists (or single, if that's the case)
     */
    public function getArtistsAsString($separator = ', ')
    {
        $out = '';

        /**
         * @var                                               $index
         * @var \Ten24\MarcatoIntegrationBundle\Entity\Artist $artist
         */
        foreach ($this->getArtists() as $index => $artist)
        {
            $out .= $artist->getName() . (($index + 1) != count($this->getArtists()) ? $separator : '');
        }

        return $out;
    }
}
