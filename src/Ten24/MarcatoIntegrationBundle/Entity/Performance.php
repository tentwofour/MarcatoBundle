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
 * @Serializer\ExclusionPolicy("none")
 */
class Performance extends AbstractEntity
{
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
     * @ORM\Column(name="end_time", type="datetime", options={"default" = NULL}, nullable=true)
     * @Serializer\SerializedName("end")
     * @Serializer\Type("DateTime<'H:i A'>")
     */
    private $endTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer", nullable=true)
     * @Serializer\SerializedName("rank")
     * @Serializer\Type("integer")
     */
    private $position;

    /**
     * @todo - Add a handler to join the Artist (<performanceDate>-<artistName>)
     * @Gedmo\Slug(fields={"startTime"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * Marcato doesn't output the entire artist here, just the name and artist_id, so there's no relation
     * @ORM\Column(name="artist_id", type="integer", nullable=false)
     * @Serializer\SerializedName("artist_id")
     * @Serializer\Type("integer")
     */
    private $artistId;

    /**
     * @ORM\ManyToOne(targetEntity="Ten24\MarcatoIntegrationBundle\Entity\Show", inversedBy="performances", cascade={"persist", "merge"})
     * @ORM\JoinColumn(name="show_id", referencedColumnName="id", nullable=false, unique=false, onDelete="CASCADE")
     * @Serializer\Exclude()
     */
    private $show;

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     * @return ShowPerformance
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
     * @return ShowPerformance
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
     * Set position
     *
     * @param integer $position
     * @return ShowPerformance
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
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
     * @return Artist

     */
    public function getArtistId()
    {
        return $this->artistId;
    }

    /**
     * @param $artistId
     * @return Performance
     */
    public function setArtistId($artistId)
    {
        $this->artistId = $artistId;

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
}
