<?php

namespace Ten24\MarcatoIntegrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Tag
 *
 * @ORM\Table(name="ten24_marcato_tags")
 * @ORM\Entity(repositoryClass="Ten24\MarcatoIntegrationBundle\Repository\TagRepository")
 */
class Tag //extends AbstractEntity
{
    /**
     * This model doesn't have a Marcato ID!
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Exclude()
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\SerializedName("category")
     * @Serializer\XmlValue(cdata=false)
     */
    private $name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Tag
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
}
