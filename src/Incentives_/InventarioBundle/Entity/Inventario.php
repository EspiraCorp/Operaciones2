<?php

namespace Incentives\InventarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inventario
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Inventario
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
     * @ORM\ManyToOne(targetEntity="Incentives\CatalogoBundle\Entity\Producto", inversedBy="inventario")
     * @ORM\JoinColumn(name="producto_id", referencedColumnName="id", nullable=true)
     */
    protected $producto;

    /**
     * @ORM\ManyToOne(targetEntity="Incentives\OperacionesBundle\Entity\Convocatorias", inversedBy="inventario")
     * @ORM\JoinColumn(name="convocatoria_id", referencedColumnName="id", nullable=true)
     */
    protected $convocatoria;

    /**
     * @ORM\ManyToOne(targetEntity="Incentives\RedencionesBundle\Entity\Redenciones", inversedBy="inventario")
     * @ORM\JoinColumn(name="redencion_id", referencedColumnName="id", nullable=true)
     */
    protected $redencion;
    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="Incentives\SolicitudesBundle\Entity\Solicitud")
     * @ORM\JoinColumn(name="solicitud_id", referencedColumnName="id", nullable=true)
     * 
     */
    protected $solicitud;

    /**
     * @ORM\ManyToOne(targetEntity="Incentives\InventarioBundle\Entity\Planilla", inversedBy="inventario")
     * @ORM\JoinColumn(name="planilla_id", referencedColumnName="id", nullable=true)
     */
    protected $planilla;

    /**
     * @ORM\ManyToOne(targetEntity="Incentives\OrdenesBundle\Entity\OrdenesCompra", inversedBy="inventario")
     * @ORM\JoinColumn(name="orden_id", referencedColumnName="id", nullable=true)
     */
    protected $orden;
    
    /**
     * @ORM\ManyToOne(targetEntity="Incentives\OrdenesBundle\Entity\OrdenesProducto", inversedBy="inventario")
     * @ORM\JoinColumn(name="ordenproducto_id", referencedColumnName="id", nullable=true)
     */
    protected $ordenproducto;
    
    /**
     * @ORM\ManyToOne(targetEntity="Incentives\InventarioBundle\Entity\Despachos", inversedBy="inventario")
     * @ORM\JoinColumn(name="despacho_id", referencedColumnName="id", nullable=true)
     */
    protected $despacho;
    
     /**
     * @ORM\OneToMany(targetEntity="Incentives\InventarioBundle\Entity\InventarioGuia", mappedBy="inventario", cascade={"persist"})
     * 
     */
    protected $inventarioguia;

    /**
     * @ORM\OneToMany(targetEntity="Incentives\RedencionesBundle\Entity\GuiaEnvio", mappedBy="inventario", cascade={"persist"})
     * 
     */
    protected $guia;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ingreso", type="boolean", nullable=true)
     */
    private $ingreso;

    /**
     * @var boolean
     *
     * @ORM\Column(name="salio", type="boolean", nullable=true)
     */
    private $salio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaEntrada", type="datetime", nullable=true)
     */
    private $fechaEntrada;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaSalida", type="datetime", nullable=true)
     */
    private $fechaSalida;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=255, nullable=true)
     */
    private $observacion;

    /**
     * @ORM\OneToMany(targetEntity="InventarioHistorico", mappedBy="inventario", cascade={"persist"})
     * 
     */
    protected $historico;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255, nullable=true)
     */
    private $codigo;

    /**
     * @ORM\ManyToOne(targetEntity="Incentives\InventarioBundle\Entity\Requisicionesenvios", inversedBy="inventario")
     * @ORM\JoinColumn(name="envio_id", referencedColumnName="id", nullable=true)
     */
    protected $requisicionesesenvios;
    
    /**
     * @var float
     *
     * @ORM\Column(name="valorCompra", type="float", nullable=true)
     */
    private $valorCompra;
    
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
     * Constructor
     */
    public function __construct()
    {
        $this->inventarioguia = new \Doctrine\Common\Collections\ArrayCollection();
        $this->guia = new \Doctrine\Common\Collections\ArrayCollection();
        $this->historico = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set ingreso
     *
     * @param boolean $ingreso
     * @return Inventario
     */
    public function setIngreso($ingreso)
    {
        $this->ingreso = $ingreso;
    
        return $this;
    }

    /**
     * Get ingreso
     *
     * @return boolean 
     */
    public function getIngreso()
    {
        return $this->ingreso;
    }

    /**
     * Set salio
     *
     * @param boolean $salio
     * @return Inventario
     */
    public function setSalio($salio)
    {
        $this->salio = $salio;
    
        return $this;
    }

    /**
     * Get salio
     *
     * @return boolean 
     */
    public function getSalio()
    {
        return $this->salio;
    }

    /**
     * Set fechaEntrada
     *
     * @param \DateTime $fechaEntrada
     * @return Inventario
     */
    public function setFechaEntrada($fechaEntrada)
    {
        $this->fechaEntrada = $fechaEntrada;
    
        return $this;
    }

    /**
     * Get fechaEntrada
     *
     * @return \DateTime 
     */
    public function getFechaEntrada()
    {
        return $this->fechaEntrada;
    }

    /**
     * Set fechaSalida
     *
     * @param \DateTime $fechaSalida
     * @return Inventario
     */
    public function setFechaSalida($fechaSalida)
    {
        $this->fechaSalida = $fechaSalida;
    
        return $this;
    }

    /**
     * Get fechaSalida
     *
     * @return \DateTime 
     */
    public function getFechaSalida()
    {
        return $this->fechaSalida;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return Inventario
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
     * Set codigo
     *
     * @param string $codigo
     * @return Inventario
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    
        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set valorCompra
     *
     * @param float $valorCompra
     * @return Inventario
     */
    public function setValorCompra($valorCompra)
    {
        $this->valorCompra = $valorCompra;
    
        return $this;
    }

    /**
     * Get valorCompra
     *
     * @return float 
     */
    public function getValorCompra()
    {
        return $this->valorCompra;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     * @return Inventario
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
     * Set producto
     *
     * @param \Incentives\CatalogoBundle\Entity\Producto $producto
     * @return Inventario
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
     * Set convocatoria
     *
     * @param \Incentives\OperacionesBundle\Entity\Convocatorias $convocatoria
     * @return Inventario
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
     * Set redencion
     *
     * @param \Incentives\RedencionesBundle\Entity\Redenciones $redencion
     * @return Inventario
     */
    public function setRedencion(\Incentives\RedencionesBundle\Entity\Redenciones $redencion = null)
    {
        $this->redencion = $redencion;
    
        return $this;
    }

    /**
     * Get redencion
     *
     * @return \Incentives\RedencionesBundle\Entity\Redenciones 
     */
    public function getRedencion()
    {
        return $this->redencion;
    }

    /**
     * Set solicitud
     *
     * @param \Incentives\SolicitudesBundle\Entity\Solicitud $solicitud
     * @return Inventario
     */
    public function setSolicitud(\Incentives\SolicitudesBundle\Entity\Solicitud $solicitud = null)
    {
        $this->solicitud = $solicitud;
    
        return $this;
    }

    /**
     * Get solicitud
     *
     * @return \Incentives\SolicitudesBundle\Entity\Solicitud 
     */
    public function getSolicitud()
    {
        return $this->solicitud;
    }

    /**
     * Set planilla
     *
     * @param \Incentives\InventarioBundle\Entity\Planilla $planilla
     * @return Inventario
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
     * Set orden
     *
     * @param \Incentives\OrdenesBundle\Entity\OrdenesCompra $orden
     * @return Inventario
     */
    public function setOrden(\Incentives\OrdenesBundle\Entity\OrdenesCompra $orden = null)
    {
        $this->orden = $orden;
    
        return $this;
    }

    /**
     * Get orden
     *
     * @return \Incentives\OrdenesBundle\Entity\OrdenesCompra 
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set ordenproducto
     *
     * @param \Incentives\OrdenesBundle\Entity\OrdenesProducto $ordenproducto
     * @return Inventario
     */
    public function setOrdenproducto(\Incentives\OrdenesBundle\Entity\OrdenesProducto $ordenproducto = null)
    {
        $this->ordenproducto = $ordenproducto;
    
        return $this;
    }

    /**
     * Get ordenproducto
     *
     * @return \Incentives\OrdenesBundle\Entity\OrdenesProducto 
     */
    public function getOrdenproducto()
    {
        return $this->ordenproducto;
    }

    /**
     * Set despacho
     *
     * @param \Incentives\InventarioBundle\Entity\Despachos $despacho
     * @return Inventario
     */
    public function setDespacho(\Incentives\InventarioBundle\Entity\Despachos $despacho = null)
    {
        $this->despacho = $despacho;
    
        return $this;
    }

    /**
     * Get despacho
     *
     * @return \Incentives\InventarioBundle\Entity\Despachos 
     */
    public function getDespacho()
    {
        return $this->despacho;
    }

    /**
     * Add inventarioguia
     *
     * @param \Incentives\InventarioBundle\Entity\InventarioGuia $inventarioguia
     * @return Inventario
     */
    public function addInventarioguia(\Incentives\InventarioBundle\Entity\InventarioGuia $inventarioguia)
    {
        $this->inventarioguia[] = $inventarioguia;
    
        return $this;
    }

    /**
     * Remove inventarioguia
     *
     * @param \Incentives\InventarioBundle\Entity\InventarioGuia $inventarioguia
     */
    public function removeInventarioguia(\Incentives\InventarioBundle\Entity\InventarioGuia $inventarioguia)
    {
        $this->inventarioguia->removeElement($inventarioguia);
    }

    /**
     * Get inventarioguia
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInventarioguia()
    {
        return $this->inventarioguia;
    }

    /**
     * Add guia
     *
     * @param \Incentives\RedencionesBundle\Entity\GuiaEnvio $guia
     * @return Inventario
     */
    public function addGuia(\Incentives\RedencionesBundle\Entity\GuiaEnvio $guia)
    {
        $this->guia[] = $guia;
    
        return $this;
    }

    /**
     * Remove guia
     *
     * @param \Incentives\RedencionesBundle\Entity\GuiaEnvio $guia
     */
    public function removeGuia(\Incentives\RedencionesBundle\Entity\GuiaEnvio $guia)
    {
        $this->guia->removeElement($guia);
    }

    /**
     * Get guia
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGuia()
    {
        return $this->guia;
    }

    /**
     * Add historico
     *
     * @param \Incentives\InventarioBundle\Entity\InventarioHistorico $historico
     * @return Inventario
     */
    public function addHistorico(\Incentives\InventarioBundle\Entity\InventarioHistorico $historico)
    {
        $this->historico[] = $historico;
    
        return $this;
    }

    /**
     * Remove historico
     *
     * @param \Incentives\InventarioBundle\Entity\InventarioHistorico $historico
     */
    public function removeHistorico(\Incentives\InventarioBundle\Entity\InventarioHistorico $historico)
    {
        $this->historico->removeElement($historico);
    }

    /**
     * Get historico
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHistorico()
    {
        return $this->historico;
    }

    /**
     * Set requisicionesesenvios
     *
     * @param \Incentives\InventarioBundle\Entity\Requisicionesenvios $requisicionesesenvios
     * @return Inventario
     */
    public function setRequisicionesesenvios(\Incentives\InventarioBundle\Entity\Requisicionesenvios $requisicionesesenvios = null)
    {
        $this->requisicionesesenvios = $requisicionesesenvios;
    
        return $this;
    }

    /**
     * Get requisicionesesenvios
     *
     * @return \Incentives\InventarioBundle\Entity\Requisicionesenvios 
     */
    public function getRequisicionesesenvios()
    {
        return $this->requisicionesesenvios;
    }

    /**
     * Set usuario
     *
     * @param \Incentives\BaseBundle\Entity\Usuario $usuario
     * @return Inventario
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