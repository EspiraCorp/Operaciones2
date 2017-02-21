<?php

namespace Incentives\CatalogoBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Premios
 *
 * @ORM\Entity
 * @ORM\Table(name="Premios")
 */
class Premios
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
     * @ORM\Column(name="puntos", type="integer", nullable=true)
     */
    private $puntos;

    /**
     * @var boolean
     *
     * @ORM\Column(name="agotado", type="boolean", nullable=true)
     */
    private $agotado;

     /**
     * 
     * @ORM\ManyToOne(targetEntity="Catalogos", inversedBy="premios", cascade={"persist"})
     * @ORM\JoinColumn(name="catalogos_id", referencedColumnName="id", nullable=true)
     * 
     */
    protected $catalogos;
    
    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="Incentives\OperacionesBundle\Entity\Categoria")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id", nullable=true)
     */
    protected $categoria;

    /**
     * @var string
     *
     * @ORM\Column(name="referencia", type="string", length=255, nullable=true)
     */
    private $referencia;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="marca", type="string", length=255, nullable=true)
     */
    private $marca;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="actualizacion", type="boolean", nullable=true)
     */
    private $actualizacion;

    /**
     * @ORM\OneToMany(targetEntity="Incentives\RedencionesBundle\Entity\Redenciones", mappedBy="premio")
     */
    protected $redencion;

    /**
     * @ORM\OneToMany(targetEntity="Promociones", mappedBy="premio")
     */
    protected $promocion;

    /**
     * @var integer
     *
     * @ORM\Column(name="puntosTemporal", type="integer", nullable=true)
     */
    private $puntosTemporal;
    
     /**
     * @var float
     * @Assert\NotNull(message="Debe escribir un valor.")
     * @ORM\Column(name="precioTemporal", type="float", nullable=true)
     */
    private $precioTemporal;

     /**
     * @var float
     *
     * @ORM\Column(name="precio", type="float", nullable=true)
     */
    private $precio;

    /**
     * @var float
     * @Assert\NotNull(message="Debe escribir un valor.")
     * @ORM\Column(name="incrementoTemporal", type="float", nullable=true)
     */
    private $incrementoTemporal;
    
    /**
     * @var float
     * @Assert\NotNull(message="Debe escribir un valor.")
     * @ORM\Column(name="logisticaTemporal", type="float", nullable=true)
     */
    private $logisticaTemporal;
    
     /**
     * @var float
     *
     * @ORM\Column(name="incremento", type="float", nullable=true)
     */
    private $incremento;
    
    /**
     * @var float
     *
     * @ORM\Column(name="logistica", type="float", nullable=true)
     */
    private $logistica;
    
    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="EstadoCatalogo")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id", nullable=true)
     */
    protected $estado;
    
    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="EstadoAprobacion")
     * @ORM\JoinColumn(name="estadoAprobacion_id", referencedColumnName="id", nullable=true)
     */
    protected $estadoAprobacion;

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="EstadoCatalogo")
     * @ORM\JoinColumn(name="aproboOperaciones_id", referencedColumnName="id", nullable=true)
     */
    protected $aproboOperaciones;

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="Incentives\BaseBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="operaciones_id", referencedColumnName="id", nullable=true)
     */
    protected $operacionesUsuario;

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="EstadoCatalogo")
     * @ORM\JoinColumn(name="aproboComercial_id", referencedColumnName="id", nullable=true)
     */
    protected $aproboComercial;

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="Incentives\BaseBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="comercial_id", referencedColumnName="id", nullable=true)
     */
    protected $comercialUsuario;

     /**
     * @var string
     * @ORM\ManyToOne(targetEntity="EstadoCatalogo")
     * @ORM\JoinColumn(name="aproboDirector_id", referencedColumnName="id", nullable=true)
     */
    protected $aproboDirector;

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="Incentives\BaseBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="director_id", referencedColumnName="id", nullable=true)
     */
    protected $directorUsuario;

     /**
     * @var string
     * @ORM\ManyToOne(targetEntity="EstadoCatalogo")
     * @ORM\JoinColumn(name="aproboCliente_id", referencedColumnName="id", nullable=true)
     */
    protected $aproboCliente;

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="Incentives\BaseBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id", nullable=true)
     */
    protected $clienteUsuario;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaInactivacion", type="datetime", nullable=true)
     */
    private $fechaInactivacion;

    /**
     * @ORM\OneToMany(targetEntity="PremiosProductos", mappedBy="premio", cascade={"persist"})
     * 
     */
    protected $premiosproductos;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=255, nullable=true)
     */
    private $imagen;

    /**
     * @var string
     *
     * @ORM\Column(name="imagenTemp", type="string", length=255, nullable=true)
     */
    private $imagenTemp;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255, nullable=true)
     */
    private $codigo;

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
        $this->redencion = new ArrayCollection();
        $this->premiosproductos = new ArrayCollection();
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
     * Set puntos
     *
     * @param integer $puntos
     *
     * @return Premios
     */
    public function setPuntos($puntos)
    {
        $this->puntos = $puntos;

        return $this;
    }

    /**
     * Get puntos
     *
     * @return integer
     */
    public function getPuntos()
    {
        return $this->puntos;
    }

    /**
     * Set agotado
     *
     * @param boolean $agotado
     *
     * @return Premios
     */
    public function setAgotado($agotado)
    {
        $this->agotado = $agotado;

        return $this;
    }

    /**
     * Get agotado
     *
     * @return boolean
     */
    public function getAgotado()
    {
        return $this->agotado;
    }

    /**
     * Set puntosTemporal
     *
     * @param integer $puntosTemporal
     *
     * @return Premios
     */
    public function setPuntosTemporal($puntosTemporal)
    {
        $this->puntosTemporal = $puntosTemporal;

        return $this;
    }

    /**
     * Get puntosTemporal
     *
     * @return integer
     */
    public function getPuntosTemporal()
    {
        return $this->puntosTemporal;
    }

    /**
     * Set precioTemporal
     *
     * @param float $precioTemporal
     *
     * @return Premios
     */
    public function setPrecioTemporal($precioTemporal)
    {
        $this->precioTemporal = $precioTemporal;

        return $this;
    }

    /**
     * Get precioTemporal
     *
     * @return float
     */
    public function getPrecioTemporal()
    {
        return $this->precioTemporal;
    }

    /**
     * Set precio
     *
     * @param float $precio
     *
     * @return Premios
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return float
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set fechaInactivacion
     *
     * @param \DateTime $fechaInactivacion
     *
     * @return Premios
     */
    public function setFechaInactivacion($fechaInactivacion)
    {
        $this->fechaInactivacion = $fechaInactivacion;

        return $this;
    }

    /**
     * Get fechaInactivacion
     *
     * @return \DateTime
     */
    public function getFechaInactivacion()
    {
        return $this->fechaInactivacion;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     *
     * @return Premios
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
     * Set catalogos
     *
     * @param \Incentives\CatalogoBundle\Entity\Catalogos $catalogos
     *
     * @return Premios
     */
    public function setCatalogos(\Incentives\CatalogoBundle\Entity\Catalogos $catalogos = null)
    {
        $this->catalogos = $catalogos;

        return $this;
    }

    /**
     * Get catalogos
     *
     * @return \Incentives\CatalogoBundle\Entity\Catalogos
     */
    public function getCatalogos()
    {
        return $this->catalogos;
    }

    /**
     * Set categoria
     *
     * @param \Incentives\OperacionesBundle\Entity\Categoria $categoria
     *
     * @return Premios
     */
    public function setCategoria(\Incentives\OperacionesBundle\Entity\Categoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \Incentives\OperacionesBundle\Entity\Categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Add redencion
     *
     * @param \Incentives\RedencionesBundle\Entity\Redenciones $redencion
     *
     * @return Premios
     */
    public function addRedencion(\Incentives\RedencionesBundle\Entity\Redenciones $redencion)
    {
        $this->redencion[] = $redencion;

        return $this;
    }

    /**
     * Remove redencion
     *
     * @param \Incentives\RedencionesBundle\Entity\Redenciones $redencion
     */
    public function removeRedencion(\Incentives\RedencionesBundle\Entity\Redenciones $redencion)
    {
        $this->redencion->removeElement($redencion);
    }

    /**
     * Get redencion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRedencion()
    {
        return $this->redencion;
    }

    /**
     * Set estado
     *
     * @param \Incentives\CatalogoBundle\Entity\EstadoCatalogo $estado
     *
     * @return Premios
     */
    public function setEstado(\Incentives\CatalogoBundle\Entity\EstadoCatalogo $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \Incentives\CatalogoBundle\Entity\EstadoCatalogo
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set estadoAprobacion
     *
     * @param \Incentives\CatalogoBundle\Entity\EstadoAprobacion $estadoAprobacion
     *
     * @return Premios
     */
    public function setEstadoAprobacion(\Incentives\CatalogoBundle\Entity\EstadoAprobacion $estadoAprobacion = null)
    {
        $this->estadoAprobacion = $estadoAprobacion;

        return $this;
    }

    /**
     * Get estadoAprobacion
     *
     * @return \Incentives\CatalogoBundle\Entity\EstadoAprobacion
     */
    public function getEstadoAprobacion()
    {
        return $this->estadoAprobacion;
    }

    /**
     * Set aproboOperaciones
     *
     * @param \Incentives\CatalogoBundle\Entity\EstadoCatalogo $aproboOperaciones
     *
     * @return Premios
     */
    public function setAproboOperaciones(\Incentives\CatalogoBundle\Entity\EstadoCatalogo $aproboOperaciones = null)
    {
        $this->aproboOperaciones = $aproboOperaciones;

        return $this;
    }

    /**
     * Get aproboOperaciones
     *
     * @return \Incentives\CatalogoBundle\Entity\EstadoCatalogo
     */
    public function getAproboOperaciones()
    {
        return $this->aproboOperaciones;
    }

    /**
     * Set operacionesUsuario
     *
     * @param \Incentives\BaseBundle\Entity\Usuario $operacionesUsuario
     *
     * @return Premios
     */
    public function setOperacionesUsuario(\Incentives\BaseBundle\Entity\Usuario $operacionesUsuario = null)
    {
        $this->operacionesUsuario = $operacionesUsuario;

        return $this;
    }

    /**
     * Get operacionesUsuario
     *
     * @return \Incentives\BaseBundle\Entity\Usuario
     */
    public function getOperacionesUsuario()
    {
        return $this->operacionesUsuario;
    }

    /**
     * Set aproboComercial
     *
     * @param \Incentives\CatalogoBundle\Entity\EstadoCatalogo $aproboComercial
     *
     * @return Premios
     */
    public function setAproboComercial(\Incentives\CatalogoBundle\Entity\EstadoCatalogo $aproboComercial = null)
    {
        $this->aproboComercial = $aproboComercial;

        return $this;
    }

    /**
     * Get aproboComercial
     *
     * @return \Incentives\CatalogoBundle\Entity\EstadoCatalogo
     */
    public function getAproboComercial()
    {
        return $this->aproboComercial;
    }

    /**
     * Set comercialUsuario
     *
     * @param \Incentives\BaseBundle\Entity\Usuario $comercialUsuario
     *
     * @return Premios
     */
    public function setComercialUsuario(\Incentives\BaseBundle\Entity\Usuario $comercialUsuario = null)
    {
        $this->comercialUsuario = $comercialUsuario;

        return $this;
    }

    /**
     * Get comercialUsuario
     *
     * @return \Incentives\BaseBundle\Entity\Usuario
     */
    public function getComercialUsuario()
    {
        return $this->comercialUsuario;
    }

    /**
     * Set aproboDirector
     *
     * @param \Incentives\CatalogoBundle\Entity\EstadoCatalogo $aproboDirector
     *
     * @return Premios
     */
    public function setAproboDirector(\Incentives\CatalogoBundle\Entity\EstadoCatalogo $aproboDirector = null)
    {
        $this->aproboDirector = $aproboDirector;

        return $this;
    }

    /**
     * Get aproboDirector
     *
     * @return \Incentives\CatalogoBundle\Entity\EstadoCatalogo
     */
    public function getAproboDirector()
    {
        return $this->aproboDirector;
    }

    /**
     * Set directorUsuario
     *
     * @param \Incentives\BaseBundle\Entity\Usuario $directorUsuario
     *
     * @return Premios
     */
    public function setDirectorUsuario(\Incentives\BaseBundle\Entity\Usuario $directorUsuario = null)
    {
        $this->directorUsuario = $directorUsuario;

        return $this;
    }

    /**
     * Get directorUsuario
     *
     * @return \Incentives\BaseBundle\Entity\Usuario
     */
    public function getDirectorUsuario()
    {
        return $this->directorUsuario;
    }

    /**
     * Set aproboCliente
     *
     * @param \Incentives\CatalogoBundle\Entity\EstadoCatalogo $aproboCliente
     *
     * @return Premios
     */
    public function setAproboCliente(\Incentives\CatalogoBundle\Entity\EstadoCatalogo $aproboCliente = null)
    {
        $this->aproboCliente = $aproboCliente;

        return $this;
    }

    /**
     * Get aproboCliente
     *
     * @return \Incentives\CatalogoBundle\Entity\EstadoCatalogo
     */
    public function getAproboCliente()
    {
        return $this->aproboCliente;
    }

    /**
     * Set clienteUsuario
     *
     * @param \Incentives\BaseBundle\Entity\Usuario $clienteUsuario
     *
     * @return Premios
     */
    public function setClienteUsuario(\Incentives\BaseBundle\Entity\Usuario $clienteUsuario = null)
    {
        $this->clienteUsuario = $clienteUsuario;

        return $this;
    }

    /**
     * Get clienteUsuario
     *
     * @return \Incentives\BaseBundle\Entity\Usuario
     */
    public function getClienteUsuario()
    {
        return $this->clienteUsuario;
    }

    /**
     * Set usuario
     *
     * @param \Incentives\BaseBundle\Entity\Usuario $usuario
     *
     * @return Premios
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

    /**
     * Set incrementoTemporal
     *
     * @param float $incrementoTemporal
     *
     * @return Premios
     */
    public function setIncrementoTemporal($incrementoTemporal)
    {
        $this->incrementoTemporal = $incrementoTemporal;

        return $this;
    }

    /**
     * Get incrementoTemporal
     *
     * @return float
     */
    public function getIncrementoTemporal()
    {
        return $this->incrementoTemporal;
    }

    /**
     * Set logisticaTemporal
     *
     * @param float $logisticaTemporal
     *
     * @return Premios
     */
    public function setLogisticaTemporal($logisticaTemporal)
    {
        $this->logisticaTemporal = $logisticaTemporal;

        return $this;
    }

    /**
     * Get logisticaTemporal
     *
     * @return float
     */
    public function getLogisticaTemporal()
    {
        return $this->logisticaTemporal;
    }

    /**
     * Set incremento
     *
     * @param float $incremento
     *
     * @return Premios
     */
    public function setIncremento($incremento)
    {
        $this->incremento = $incremento;

        return $this;
    }

    /**
     * Get incremento
     *
     * @return float
     */
    public function getIncremento()
    {
        return $this->incremento;
    }

    /**
     * Set logistica
     *
     * @param float $logistica
     *
     * @return Premios
     */
    public function setLogistica($logistica)
    {
        $this->logistica = $logistica;

        return $this;
    }

    /**
     * Get logistica
     *
     * @return float
     */
    public function getLogistica()
    {
        return $this->logistica;
    }

    /**
     * Add premiosproducto
     *
     * @param \Incentives\CatalogoBundle\Entity\PremiosProductos $premiosproducto
     *
     * @return Premios
     */
    public function addPremiosproducto(\Incentives\CatalogoBundle\Entity\PremiosProductos $premiosproducto)
    {
        $this->premiosproductos[] = $premiosproducto;

        return $this;
    }

    /**
     * Remove premiosproducto
     *
     * @param \Incentives\CatalogoBundle\Entity\PremiosProductos $premiosproducto
     */
    public function removePremiosproducto(\Incentives\CatalogoBundle\Entity\PremiosProductos $premiosproducto)
    {
        $this->premiosproductos->removeElement($premiosproducto);
    }

    /**
     * Get premiosproductos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPremiosproductos()
    {
        return $this->premiosproductos;
    }

    /**
     * Add promocion
     *
     * @param \Incentives\CatalogoBundle\Entity\Promociones $promocion
     *
     * @return Premios
     */
    public function addPromocion(\Incentives\CatalogoBundle\Entity\Promociones $promocion)
    {
        $this->promocion[] = $promocion;

        return $this;
    }

    /**
     * Remove promocion
     *
     * @param \Incentives\CatalogoBundle\Entity\Promociones $promocion
     */
    public function removePromocion(\Incentives\CatalogoBundle\Entity\Promociones $promocion)
    {
        $this->promocion->removeElement($promocion);
    }

    /**
     * Get promocion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPromocion()
    {
        return $this->promocion;
    }

    /**
     * Set referencia
     *
     * @param string $referencia
     *
     * @return Premios
     */
    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;

        return $this;
    }

    /**
     * Get referencia
     *
     * @return string
     */
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Premios
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set marca
     *
     * @param string $marca
     *
     * @return Premios
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return string
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Premios
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
     * Set actualizacion
     *
     * @param boolean $actualizacion
     *
     * @return Premios
     */
    public function setActualizacion($actualizacion)
    {
        $this->actualizacion = $actualizacion;

        return $this;
    }

    /**
     * Get actualizacion
     *
     * @return boolean
     */
    public function getActualizacion()
    {
        return $this->actualizacion;
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     *
     * @return Premios
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return string
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set imagenTemp
     *
     * @param string $imagenTemp
     *
     * @return Premios
     */
    public function setImagenTemp($imagenTemp)
    {
        $this->imagenTemp = $imagenTemp;

        return $this;
    }

    /**
     * Get imagenTemp
     *
     * @return string
     */
    public function getImagenTemp()
    {
        return $this->imagenTemp;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     *
     * @return Premios
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
}
