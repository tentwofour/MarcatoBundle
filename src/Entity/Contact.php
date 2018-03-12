<?php

namespace Ten24\MarcatoIntegrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

/**
 * Contact
 *
 * @ORM\Table(name="ten24_marcato_contacts")
 * @ORM\Entity(repositoryClass="Ten24\MarcatoIntegrationBundle\Repository\ContactRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=true)
 */
class Contact extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128, nullable=true)
     * @Serializer\Type("string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=128, nullable=true)
     * @Serializer\Type("string")
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=255, nullable=true)
     * @Serializer\Type("string")
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(name="industry", type="string", length=255, nullable=true)
     * @Serializer\Type("string")
     */
    private $industry;

    /**
     * @var string
     *
     * @ORM\Column(name="biography", type="text", nullable=true)
     * @Serializer\Type("string")
     * @Serializer\SerializedName("bio")
     */
    private $biography;

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
     * @Serializer\SerializedName("photo_fingerprint")
     */
    private $photoFingerprint;

    /**
     * @var string
     *
     * @ORM\Column(name="email_address", type="string", length=255, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\SerializedName("email")
     */
    private $emailAddress;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true, options={"default" = null})
     * @Serializer\Type("DateTime")
     * @Serializer\SerializedName("updated_at")
     */
    private $updatedAt;

    /**
     * @Gedmo\Slug(fields={"name", "name"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Contact
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
     * Set position
     *
     * @param string $position
     *
     * @return Contact
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set biography
     *
     * @param string $biography
     *
     * @return Contact
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;

        return $this;
    }

    /**
     * Get biography
     *
     * @return string
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * Set company
     *
     * @param string $company
     *
     * @return Contact
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set industry
     *
     * @param string $industry
     *
     * @return Contact
     */
    public function setIndustry($industry)
    {
        $this->industry = $industry;

        return $this;
    }

    /**
     * Get industry
     *
     * @return string
     */
    public function getIndustry()
    {
        return $this->industry;
    }

    /**
     * Set photoUrl
     *
     * @param string $photoUrl
     *
     * @return Contact
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
     * @return Contact
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
     * Set emailAddress
     *
     * @param string $emailAddress
     *
     * @return Contact
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * Get emailAddress
     *
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Contact
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
}
