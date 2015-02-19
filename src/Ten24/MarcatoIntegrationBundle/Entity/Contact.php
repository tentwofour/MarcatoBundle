<?php

namespace Ten24\MarcatoIntegrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Contact
 * @package Ten24\MarcatoIntegrationBundle\Entity
 * @todo
 */
class Contact
{
    /**
     * @ORM\Id()
     */
    private $id;

    /**
     * @ORM\Column(name="marcato_id", type="integer")
     */
    private $marcatoId;

}