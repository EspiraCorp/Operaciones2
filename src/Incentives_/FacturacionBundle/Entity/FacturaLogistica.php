<?php

namespace Incentives\FacturacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FacturaLogistica
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class FacturaLogistica
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
     * @ORM\OneToMany(targetEntity="Incentives\RedencionesBundle\Entity\GuiaEnvio", mappedBy="facturalogistica", cascade={"persist"})
     * 
     */
    protected $guias;
    
    /**
     * @ORM\OneToMany(targetEntity="Incentives\InventarioBundle\Entity\CostosLogistica", mappedBy="facturalogistica", cascade={"persist"})
     * 
     */
    protected $costosLogistica;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=true)
     */
    private $cantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var float
     *
     * @ORM\Column(name="valorUnitario", type="float", nullable=true)
     */
    private $valorUnitario;

    /**
     * @var float
     *
     * @ORM\Column(name="valorTotal", type="float", nullable=true)
     */
    private $valorTotal;

     /**
     * @var string
     * @ORM\ManyToOne(targetEntity="Incentives\FacturacionBundle\Entity\Factura", inversedBy="facturalogistica",cascade={"persist"})
     * @ORM\JoinColumn(name="factura_id", referencedColumnName="id", nullable=true)
     */
    protected $factura;

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
     * Set cantidad
     *
     * @param integer $cantidad
     * @return FacturaDetalle
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    
        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return FacturaDetalle
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set valorUnitario
     *
     * @param float $valorUnitario
     * @return FacturaDetalle
     */
    public function setValorUnitario($valorUnitario)
    {
        $this->valorUnitario = $valorUnitario;
    
        return $this;
    }

    /**
     * Get valorUnitario
     *
     * @return float 
     */
    public function getValorUnitario()
    {
        return $this->valorUnitario;
    }

    /**
     * Set valorTotal
     *
     * @param float $valorTotal
     * @return FacturaDetalle
     */
    public function setValorTotal($valorTotal)
    {
        $this->valorTotal = $valorTotal;
    
        return $this;
    }

    /**
     * Get valorTotal
     *
     * @return float 
     */
    public function getValorTotal()
    {
        return $this->valorTotal;
    }

    /**
     * Set factura
     *
     * @param \Incentives\FacturacionBundle\Entity\Factura $factura
     * @return FacturaDetalle
     */
    public function setFactura(\Incentives\FacturacionBundle\Entity\Factura $factura = null)
    {
        $this->factura = $factura;
    
        return $this;
    }

    /**
     * Get factura
     *
     * @return \Incentives\FacturacionBundle\Entity\Factura 
     */
    public function getFactura()
    {
        return $this->factura;
    }

    /**
     * Set guia
     *
     * @param \Incentives\RedencionesBundle\Entity\GuiaEnvio $guia
     * @return FacturaLogistica
     */
    public function setGuia(\Incentives\RedencionesBundle\Entity\GuiaEnvio $guia = null)
    {
        $this->guia = $guia;
    
        return $this;
    }

    /**
     * Get guia
     *
     * @return \Incentives\RedencionesBundle\Entity\GuiaEnvio 
     */
    public function getGuia()
    {
        return $this->guia;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->guias = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add guias
     *
     * @param \Incentives\RedencionesBundle\Entity\GuiaEnvio $guias
     * @return FacturaLogistica
     */
    public function addGuia(\Incentives\RedencionesBundle\Entity\GuiaEnvio $guias)
    {
        $this->guias[] = $guias;
    
        return $this;
    }

    /**
     * Remove guias
     *
     * @param \Incentives\RedencionesBundle\Entity\GuiaEnvio $guias
     */
    public function removeGuia(\Incentives\RedencionesBundle\Entity\GuiaEnvio $guias)
    {
        $this->guias->removeElement($guias);
    }

    /**
     * Get guias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGuias()
    {
        return $this->guias;
    }

    /**
     * Add costosLogistica
     *
     * @param \Incentives\InventarioBundle\Entity\CostosLogistica $costosLogistica
     * @return FacturaLogistica
     */
    public function addCostosLogistica(\Incentives\InventarioBundle\Entity\CostosLogistica $costosLogistica)
    {
        $this->costosLogistica[] = $costosLogistica;
    
        return $this;
    }

    /**
     * Remove costosLogistica
     *
     * @param \Incentives\InventarioBundle\Entity\CostosLogistica $costosLogistica
     */
    public function removeCostosLogistica(\Incentives\InventarioBundle\Entity\CostosLogistica $costosLogistica)
    {
        $this->costosLogistica->removeElement($costosLogistica);
    }

    /**
     * Get costosLogistica
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCostosLogistica()
    {
        return $this->costosLogistica;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     * @return FacturaLogistica
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
     * @return FacturaLogistica
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