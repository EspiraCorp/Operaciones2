<?php

namespace Incentives\OperacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * ConvocatoriasArchivos
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ConvocatoriasArchivos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="archivo", type="string", length=255, nullable=true)
     */
    private $archivo;
    
     /**
     * 
     * @ORM\ManyToOne(targetEntity="Convocatorias")
     * @ORM\JoinColumn(name="convocatoria_id", referencedColumnName="id", nullable=true)
     * 
     */
    protected $convocatoria;
    
    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="Incentives\CatalogoBundle\Entity\Estados")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id", nullable=true)
     */
    protected $estado;

   /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaModificacion", type="datetime", nullable=true)
     */
    private $fechaModificacion;
    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="Incentives\BaseBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=true)
     * 
     */
    protected $usuario;

    public function __construct()
    {
        $this->estado='1';   
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set archivo
     *
     * @param string $archivo
     * @return ConvocatoriasArchivos
     */
    public function setArchivo($archivo)
    {
        $this->archivo = $archivo;
    
        return $this;
    }

    /**
     * Get archivo
     *
     * @return string 
     */
    public function getArchivo()
    {
        return $this->archivo;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     * @return ConvocatoriasArchivos
     */
    public function setFechaModificacion($fechaModificacion)
    {
        $this->fechaModificacion = $fechaModificacion;
    
        return $this;
    }

    /**
     * Get fechaModificacion
     *
     * @return \DateTime 
     */
    public function getFechaModificacion()
    {
        return $this->fechaModificacion;
    }

    /**
     * Set convocatoria
     *
     * @param \Incentives\OperacionesBundle\Entity\Convocatorias $convocatoria
     * @return ConvocatoriasArchivos
     */
    public function setConvocatoria(\Incentives\OperacionesBundle\Entity\Convocatorias $convocatoria = null)
    {
        $this->convocatoria = $convocatoria;
    
        return $this;
    }

    /**
     * Get convocatoria
     *
     * @return \Incentives\OperacionesBundle\Entity\Convocatorias 
     */
    public function getConvocatoria()
    {
        return $this->convocatoria;
    }
    
    
    /**
     * Set estado
     *
     * @param \Incentives\CatalogoBundle\Entity\Estados $estado
     * @return ConvocatoriasArchivos
     */
    public function setEstado(\Incentives\CatalogoBundle\Entity\Estados $estado = null)
    {
        $this->estado = $estado;
    
        return $this;
    }

    /**
     * Get estado
     *
     * @return \Incentives\CatalogoBundle\Entity\Estados 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set usuario
     *
     * @param \Incentives\BaseBundle\Entity\Usuario $usuario
     * @return ConvocatoriasArchivos
     */
    public function setUsuario(\Incentives\BaseBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;
    
        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Incentives\BaseBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}