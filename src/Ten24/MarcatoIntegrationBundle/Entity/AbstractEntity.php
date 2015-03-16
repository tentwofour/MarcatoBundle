<?php

namespace Ten24\MarcatoIntegrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class AbstractEntity
 * @package Ten24\MarcatoIntegrationBundle\Entity
 */
abstract class AbstractEntity
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @Serializer\Type("integer")
     */
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return AbstractEntity
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}