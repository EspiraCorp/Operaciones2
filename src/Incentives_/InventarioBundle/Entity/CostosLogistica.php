<?php

namespace Incentives\InventarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CostosLogistica
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Incentives\InventarioBundle\Entity\CostosLogisticaRepository")
 */
class CostosLogistica
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
     * @var float
     *
     * @ORM\Column(name="valorUnitario", type="float", nullable=true)
     */
    private $valorUnitario;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=true)
     */
    private $cantidad;

    /**
     * @var float
     *
     * @ORM\Column(name="valorTotal", type="float", nullable=true)
     */
    private $valorTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=255, nullable=true)
     */
    private $observacion;
    
    /**
     * @ORM\ManyToOne(targetEntity="Planilla", inversedBy="costosLogistica")
     * @ORM\JoinColumn(name="planilla_id", referencedColumnName="id", nullable=true)
     */
    protected $planilla;
    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="\Incentives\FacturacionBundle\Entity\FacturaLogistica", inversedBy="costosLogistica", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="facturaLogistica_id", referencedColumnName="id", nullable=true)
     * 
     */
    protected $facturalogistica;

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
     * Set valorUnitario
     *
     * @param float $valorUnitario
     * @return CostosLogistica
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
     * Set cantidad
     *
     * @param integer $cantidad
     * @return CostosLogistica
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
     * Set valorTotal
     *
     * @param float $valorTotal
     * @return CostosLogistica
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return CostosLogistica
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
     * Set observacion
     *
     * @param string $observacion
     * @return CostosLogistica
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;
    
        return $this;
    }

    /**
     * Get observacion
     *
     * @return string 
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set planilla
     *
     * @param \Incentives\InventarioBundle\Entity\Planilla $planilla
     * @return CostosLogistica
     */
    public function setPlanilla(\Incentives\InventarioBundle\Entity\Planilla $planilla = null)
    {
        $this->planilla = $planilla;
    
        return $this;
    }

    /**
     * Get planilla
     *
     * @return \Incentives\InventarioBundle\Entity\Planilla 
     */
    public function getPlanilla()
    {
        return $this->planilla;
    }

    /**
     * Set facturalogistica
     *
     * @param \Incentives\FacturacionBundle\Entity\FacturaLogistica $facturalogistica
     * @return CostosLogistica
     */
    public function setFacturalogistica(\Incentives\FacturacionBundle\Entity\FacturaLogistica $facturalogistica = null)
    {
        $this->facturalogistica = $facturalogistica;
    
        return $this;
    }

    /**
     * Get facturalogistica
     *
     * @return \Incentives\FacturacionBundle\Entity\FacturaLogistica 
     */
    public function getFacturalogistica()
    {
        return $this->facturalogistica;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     * @return CostosLogistica
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
     * @return CostosLogistica
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