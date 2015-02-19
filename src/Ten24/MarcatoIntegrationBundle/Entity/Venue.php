<?php

namespace Ten24\MarcatoIntegrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Venue
 * @package Ten24\MarcatoIntegrationBundle\Entity
 * @todo
 */
class Venus
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