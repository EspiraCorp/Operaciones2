<?php

namespace Incentives\CatalogoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductoCalificacion
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ProductoCalificacion
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
     * @var integer
     *
     * @ORM\Column(name="valor", type="smallint", nullable=true)
     */
    private $valor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

     /**
     * 
     * @ORM\ManyToOne(targetEntity="Producto", inversedBy="calificacion", cascade={"persist"})
     * @ORM\JoinColumn(name="producto_id", referencedColumnName="id", nullable=true)
     * 
     */
    protected $producto;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="Catalogos", inversedBy="calificacion", cascade={"persist"})
     * @ORM\JoinColumn(name="catalogo_id", referencedColumnName="id", nullable=true)
     * 
     */
    protected $catalogo;

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
        $this->fecha = new \DateTime("now");
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
     * Set valor
     *
     * @param integer $valor
     * @return ProductoCalificacion
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set producto
     *
     * @param \Incentives\CatalogoBundle\Entity\Producto $producto
     * @return ProductoCalificacion
     */
    public function setProducto(\Incentives\CatalogoBundle\Entity\Producto $producto = null)
    {
        $this->producto = $producto;
    
        return $this;
    }

    /**
     * Get producto
     *
     * @return \Incentives\CatalogoBundle\Entity\Producto 
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return ProductoCalificacion
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    
        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set catalogo
     *
     * @param \Incentives\CatalogoBundle\Entity\Catalogos $catalogo
     * @return ProductoCalificacion
     */
    public function setCatalogo(\Incentives\CatalogoBundle\Entity\Catalogos $catalogo = null)
    {
        $this->catalogo = $catalogo;
    
        return $this;
    }

    /**
     * Get catalogo
     *
     * @return \Incentives\CatalogoBundle\Entity\Catalogos 
     */
    public function getCatalogo()
    {
        return $this->catalogo;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     * @return ProductoCalificacion
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
     * Set usuario
     *
     * @param \Incentives\BaseBundle\Entity\Usuario $usuario
     * @return ProductoCalificacion
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