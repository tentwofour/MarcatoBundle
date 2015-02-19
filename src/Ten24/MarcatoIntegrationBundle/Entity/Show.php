<?php

namespace Ten24\MarcatoIntegrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Show
 * @package Ten24\MarcatoIntegrationBundle\Entity
 * @todo
 */
class Show
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