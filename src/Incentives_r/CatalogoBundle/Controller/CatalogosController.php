<?php

namespace Incentives\CatalogoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Incentives\CatalogoBundle\Entity\Programa;
use Incentives\CatalogoBundle\Form\Type\ProgramaType;
use Incentives\CatalogoBundle\Entity\Catalogos;
use Incentives\CatalogoBundle\Entity\Intervalos;
use Incentives\CatalogoBundle\Form\Type\IntervalosType;
use Incentives\CatalogoBundle\Form\Type\CatalogosType;
use Incentives\CatalogoBundle\Form\Type\CatalogosnuevoType;
use Incentives\CatalogoBundle\Form\Type\ProductoType;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Writer_Excel2007;
use PHPExcel_Cell_DataValidation;
use PHPExcel_Worksheet_Drawing;
use PHPExcel_Style_Fill;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CatalogosController extends Controller
{
    /**
     * @Route("/catalogo/nuevo")
     * @Template()
     */
    public function nuevoAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $catalogo = new Catalogos();
        if (isset($id)){
            $programa = $em->getRepository('IncentivesCatalogoBundle:Programa')->find($id);
            $form = $this->createForm(CatalogosType::class, $catalogo);
        }else{
            $programa = new Programa();
            $form = $this->createForm(CatalogosnuevoType::class, $catalogo);
        }        
                    
        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $id=($this->get('request')->request->get('id'));
                if ($id==0){
                    $id=$catalogo->getPrograma()->getId();
                }
                $programa = $em->getRepository('IncentivesCatalogoBundle:Programa')->find($id);
                $catalogo->setPrograma($programa);
                $estado = $em->getRepository('IncentivesCatalogoBundle:Estados')->find(1);
                $catalogo->setEstado($estado);
                $em->persist($catalogo);

                $em->flush();

                return $this->redirect($this->generateUrl('programa_datos').'/'.$id);
            }
        }          
        if ($id!=0){
            return $this->render('IncentivesCatalogoBundle:Catalogos:nuevo.html.twig', array(
                'form' => $form->createView(), 'id'=>$id
            ));
        }else{
            return $this->render('IncentivesCatalogoBundle:Catalogos:nuevo1.html.twig', array(
                'form' => $form->createView(), 'id'=>$id
            ));
        }
    }

    /**
     * @Route("/catalogo/editar")
     * @Template()
     */
    public function editarAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        if (isset($id)){
            $catalogo = $em->getRepository('IncentivesCatalogoBundle:Catalogos')->find($id);
            $form = $this->createForm(CatalogosType::class, $catalogo);
        }else{
            $form = $this->createForm(CatalogosType::class);
            $catalogo = new Catalogos();
        }

        if ($request->isMethod('POST')) {
            $form->bind($request);


            if ($form->isValid()) {                
                $pro=($this->get('request')->request->get('catalogos'));
                $id=($this->get('request')->request->get('id'));
                $catalogo = $em->getRepository('IncentivesCatalogoBundle:Catalogos')->find($id);
                $catalogo->setNombre($pro["nombre"]);
                $catalogo->setDescripcion($pro["descripcion"]);
                $catalogo->setValorpunto($pro["valorPunto"]);
                
                $tipo = $em->getRepository('IncentivesCatalogoBundle:Catalogotipo')->find($pro["catalogotipo"]);
                $catalogo->setCatalogotipo($tipo);

                $em->persist($catalogo);   
                $em->flush();

                //$conn = $this->get('database_connection'); 

                //$excelcar = $conn->insert('Programa', array('fechainicio' => date($pro["fechainicio"]["year"]."-". $pro["fechainicio"]["month"]."-".$pro["fechainicio"]["day"])));

                return $this->redirect($this->generateUrl('catalogo_datos').'/'.$id);
            }
        }


        return $this->render('IncentivesCatalogoBundle:Catalogos:editar.html.twig', array(
            'form' => $form->createView(), 'catalogo' => $catalogo, 'id'=>$id,
        ));
    }

    /**
     * @Route("/catalogo/datos/{id}")
     * @Template()
     */
    public function datosAction($id)
    {
        $repositoryca = $this->getDoctrine()
            ->getRepository('IncentivesCatalogoBundle:Catalogos');

        $catalogo = $repositoryca->find($id);
        
        $repositoryInt = $this->getDoctrine()
            ->getRepository('IncentivesCatalogoBundle:Intervalos');

        $intervalos = $repositoryInt->findByCatalogos($id);

		$galeria = 0;
        if ($this->get('security.authorization_checker')->isGranted('ROLE_CLI')) {
            $cliente =  $this->getUser()->getCliente()->getId();      
            if($cliente==28) $galeria = 1;
        }

        return $this->render('IncentivesCatalogoBundle:Catalogos:datos.html.twig', 
            array( 'id'=>$id, 'catalogo'=>$catalogo, 'intervalos' => $intervalos, 'galeria' => $galeria));
    }

    /**
     * @Route("/catalogo")
     * @Template()
     */
    public function listadoAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $this->getDoctrine()
            ->getRepository('IncentivesCatalogoBundle:Catalogos');

        $listado= $repository->findAll();

        $query = $em->createQueryBuilder()
                ->select('c','p','cl') 
                ->from('IncentivesCatalogoBundle:Catalogos', 'c')
                ->leftJoin('c.programa','p')
                ->leftJoin('p.cliente','cl')
                ->orderBy("c.id");

        if ($this->get('security.authorization_checker')->isGranted('ROLE_CLI')) {
            $cliente =  $this->getUser()->getCliente()->getId();
            $condicion = " cl.id=".$cliente;
            $query->where($condicion);
        }

        $listado = $query->getQuery()->getResult();

        return $this->render('IncentivesCatalogoBundle:Catalogos:listado.html.twig', 
            array('listado' => $listado));
    }

    /**
     * @Route("/catalogo/estado/{id}")
     * @Template()
     */
    public function estadoAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $catalogo = $em->getRepository('IncentivesCatalogoBundle:Catalogos')->find($id);

        if ($catalogo->getEstado()->getId() == 1){
            $estado = $em->getRepository('IncentivesCatalogoBundle:Estados')->find(2);
            $catalogo->setEstado($estado);
            
            //inhabilitar de todos los catalogos
            $repositorypc = $this->getDoctrine()->getRepository('IncentivesCatalogoBundle:Productocatalogo');
            $productocatalogo = $repositorypc->findByCatalogos($id);
            
            foreach($productocatalogo as $keyP => $valueP){
                
                $valueP->setActivo(0);
                $em->persist($valueP);
                $em->flush();
                
            }
            
        }else{
            $estado = $em->getRepository('IncentivesCatalogoBundle:Estados')->find(1);
            $catalogo->setEstado($estado);
        }       
        $em->flush();
       
        return $this->redirect($this->generateUrl('catalogo'));
    }



    public function importarAction(Request $request)
    {
        
        $excelForm = new Excel();
        $form = $this->createFormBuilder($excelForm)
            ->setAction($this->generateUrl('proveedores_importar'))
            ->setMethod('POST')
            ->add('excel', 'file')
            ->add('cargar', 'submit')
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->bind($request);

            $excel = $form['excel']->getData();

            $objPHPExcel = PHPExcel_IOFactory::load($excel);

            

            //$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            $sheetData = $objPHPExcel->getSheet(0)->toArray(null,true,true,true);

            $worksheet  = $objPHPExcel->setActiveSheetIndex('0');
            $ultimaFila = $worksheet->getHighestRow(); // e.g. 10
      
            $conn = $this->get('database_connection');
            //$excelcar = $conn->insert('Cargaexcel', array('username' => 'jwage'));
                // INSERT INTO user (username) VALUES (?) (jwage)

            $date = date_create();
            $fecha = date_format($date, 'Y-m-d');  
            
            $repetidos_corr = array();
            $repetidos_doc = array();
            $fila=1;
            
            foreach ($sheetData as $row) {
                if($fila > 1){
                    $rep_doc = $this->buscarepetidos($row['F'],'numero_documento');
                    $rep_correo = $this->buscarepetidos($row['I'],'correo');
                    
                    if(count($rep_doc)) array_push($repetidos_doc, $rep_doc);
                    if(count($rep_correo)) array_push($repetidos_corr, $rep_correo);
                    
                }
            }
        }
    }

    public function indicadoresAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $catalogo = $em->getRepository('IncentivesCatalogoBundle:Catalogos')->find($id);

        $query = $em->createQueryBuilder()
                ->select('c.nombre','count(pc) as total') 
                ->addSelect("SUM(CASE WHEN (pc.activo = 1 AND (pc.estadoAprobacion IS NULL OR pc.estadoAprobacion=0)) THEN 1 ELSE 0 END) AS operaciones")
                ->addSelect("SUM(CASE WHEN (pc.activo = 1 AND pc.estadoAprobacion=1) THEN 1 ELSE 0 END) AS comercial")
                ->addSelect("SUM(CASE WHEN (pc.activo = 1 AND pc.estadoAprobacion=2) THEN 1 ELSE 0 END) AS director")
                ->addSelect("SUM(CASE WHEN (pc.activo = 1 AND pc.estadoAprobacion=3) THEN 1 ELSE 0 END) AS cliente")
                ->addSelect("SUM(CASE WHEN (pc.activo = 1 AND pc.estadoAprobacion=4) THEN 1 ELSE 0 END) AS visibles")
                ->addSelect("SUM(CASE WHEN (pc.activo != 1 OR p.estado!=1 OR pc.activo is NULL OR p.estado IS NULL OR pc.aproboOperaciones=2 OR pc.aproboComercial=2 OR pc.aproboDirector=2 OR pc.aproboCliente=2) THEN 1 ELSE 0 END) AS inactivos")
                ->from('IncentivesCatalogoBundle:Productocatalogo', 'pc')
                ->leftJoin('pc.categoria','c')
                ->leftJoin('pc.producto','p')
                ->orderBy("c.nombre")
                ->groupBy("c.id")
                ->where("pc.catalogos=".$id);

        $categorias = $query->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        //echo "<pre>"; print_r($categorias); echo "</pre>"; exit;
        return $this->render('IncentivesCatalogoBundle:Catalogos:indicadores.html.twig', 
            array('catalogo' => $catalogo, 'categorias' => $categorias));
    }

    public function galeriaAction($id, $vista)
    {
        $form = $this->createForm(ProductoType::class);

        $em = $this->getDoctrine()->getManager();
     
        $session = $this->get('session');
            
        $page = $this->get('request')->get('page');
        if(!$page) $page= 1;
            
        if($pro=($this->get('request')->request->get('producto'))){
            $page = 1;
            $session->set('filtros_galeria', $pro);
        }

        if(isset($vista)){
            $session->set('filtros_galeria_vista', $vista);
        }


        $condicionesFiltro = "";

        if($filtros = $session->get('filtros_galeria')){
               
               foreach($filtros as $Filtro => $valueF){
                   
                   if($valueF!=""){
                       if($Filtro=="categoria"){
                            $condicionesFiltro .= " AND c.id=".$valueF."";
                       }elseif($Filtro=="estado"){
                            $condicionesFiltro .= " AND i.estado=".$valueF."";
                       }elseif($Filtro=="precio"){
                            $condicionesFiltro .= " AND pc.precio=".$valueF."";
                       }else{
                            $condicionesFiltro .= " AND p.".$Filtro." LIKE '%".$valueF."%'";
                       }
                       
                   };
               } 
         }

        $query = $em->createQueryBuilder()
                ->select('pc','p','i','c') 
                ->from('IncentivesCatalogoBundle:Productocatalogo', 'pc')
                ->leftJoin('pc.producto','p')
                ->leftJoin('pc.categoria','c')
                ->leftJoin('p.imagenproducto','i','WITH','i.estado=1')
                ->orderBy("pc.puntos");

        $condiciones = "pc.catalogos=".$id." AND pc.activo = 1 AND p.estado=1";

        if($idVista = $session->get('filtros_galeria_vista')){
            if ($idVista==1) {
                $condiciones .= " AND (pc.aproboCliente=1 AND pc.aproboOperaciones=1 AND pc.aproboComercial=1 AND pc.aproboDirector=1)";
            }

            if ($idVista==2) {
                $condiciones .= " AND (pc.estadoAprobacion=3 AND pc.aproboOperaciones=1 AND pc.aproboComercial=1 AND pc.aproboDirector=1)";
            }
            
            if ($idVista==3) {
                $condiciones .= " AND (pc.estadoAprobacion=2 AND pc.aproboOperaciones=1 AND pc.aproboComercial=1)";
            }

            if ($idVista==4) {
                $condiciones .= " AND (pc.estadoAprobacion=1 AND pc.aproboOperaciones=1)";
            }

            if ($idVista==5) {
                $condiciones .= " AND ((pc.aproboOperaciones=0 OR pc.aproboOperaciones IS NULL) AND (pc.estadoAprobacion IS NULL OR pc.estadoAprobacion=0))";
            }

            if ($idVista==0) {
                $session->set('filtros_galeria_vista');
            }
        }
        
        if($this->get('request')->get('sort')){
            $query->orderBy($this->get('request')->get('sort'), $this->get('request')->get('direction'));    
        }
        
        $precioVenta=0;
        if ($this->get('security.authorization_checker')->isGranted('ROLE_CLI')) {
           $condiciones .= " AND (pc.aproboCliente=1 AND pc.aproboOperaciones=1 AND pc.aproboComercial=1 AND pc.aproboDirector=1)";
		   $cliente =  $this->getUser()->getCliente()->getId();      
           if($cliente==28) $precioVenta = 1;
        }

        $catalogo = $em->getRepository('IncentivesCatalogoBundle:Catalogos')->find($id);

        $query->where($condiciones.$condicionesFiltro);
        $productos = $query->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $productos,
            $this->get('request')->query->get('page', 1)/*page number*/,
            20 /*limit per page*/
        );

        $catalogo = $em->getRepository('IncentivesCatalogoBundle:Catalogos')->find($id);
        
         return $this->render('IncentivesCatalogoBundle:Catalogos:galeria.html.twig', 
            array('productos' => $pagination, 'id'=>$id, 'form' => $form->createView(), 'catalogo'=>$catalogo, 'precioVenta' => $precioVenta));
    }

    public function navegarAction()
    {
        $em = $this->getDoctrine()->getManager();
        $imagenes = $em->getRepository('IncentivesCatalogoBundle:Imagenproducto')->findAll();
        $productos = $em->getRepository('IncentivesCatalogoBundle:Producto')->findAll();

        return $this->render('IncentivesCatalogoBundle:Catalogos:navegar.html.twig', 
            array('imagenes' => $imagenes, 'productos' => $productos));
    }
    
    public function aprobarAction($id, $resumido = 0)
    {
        $form = $this->createForm(ProductoType::class);

        $em = $this->getDoctrine()->getManager();
     
        $session = $this->get('session');
            
        $page = $this->get('request')->get('page');
        if(!$page) $page= 1;
            
        if($pro=($this->get('request')->request->get('producto'))){
            $page = 1;
            $session->set('filtros_aprobar', $pro);
        }

        $condicionesFiltro = "";

        if($filtros = $session->get('filtros_aprobar')){
               
               foreach($filtros as $Filtro => $valueF){
                   
                   if($valueF!=""){
                       if($Filtro=="categoria"){
                            $condicionesFiltro .= " AND c.id=".$valueF."";
                        //}elseif($Filtro=="estado"){
                        //    $condicionesFiltro .= " AND i.estado=".$valueF."";
                       }elseif($Filtro=="precio"){
                            $condicionesFiltro .= " AND pc.precio=".$valueF."";
                       }else{
                            $condicionesFiltro .= " AND p.".$Filtro." LIKE '%".$valueF."%'";
                       }
                       
                   };
               } 
         }

        $query = $em->createQueryBuilder()
                ->select('pc','p','i','c') 
                ->from('IncentivesCatalogoBundle:Productocatalogo', 'pc')
                ->leftJoin('pc.producto','p')
                ->leftJoin('pc.categoria','c')
                ->leftJoin('p.imagenproducto','i','WITH','i.estado=1')
                ->orderBy("pc.puntos");

        if ($this->get('security.authorization_checker')->isGranted('ROLE_EJEC')) {
            $condiciones = "pc.catalogos=".$id." AND pc.estadoAprobacion=1 ";
        }

        if ($this->get('security.authorization_checker')->isGranted('ROLE_COM')) {
            $condiciones = "pc.catalogos=".$id." AND pc.estadoAprobacion=2 ";
        }

        if ($this->get('security.authorization_checker')->isGranted('ROLE_CLI')) {
            $condiciones = "pc.catalogos=".$id." AND pc.estadoAprobacion=3 ";
        }

        if ($this->get('security.authorization_checker')->isGranted('ROLE_DIR') || $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') || $this->get('security.authorization_checker')->isGranted('ROLE_CAT')) {
            $condiciones = "pc.catalogos=".$id." AND (pc.estadoAprobacion=0 OR pc.estadoAprobacion IS NULL)";
        }

        if($this->get('request')->get('sort')){
            $query->orderBy($this->get('request')->get('sort'), $this->get('request')->get('direction'));    
        }

        $condiciones .= " AND pc.activo=1 ";
        
        $query->where($condiciones.$condicionesFiltro);
        $productos = $query->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        
        foreach($productos as $key => $value){
            
            $productos[$key]['valorventa'] = 0 + $value['precioTemporal']/(1-($value['incrementoTemporal']/100)) + $value['logisticaTemporal'];
            $valorventa[$key] = 0 + $productos[$key]['valorventa'];
           
        }
        
        $this->array_sort_by_column($productos, 'valorventa');
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $productos,
            $this->get('request')->query->get('page', 1)/*page number*/,
            20 /*limit per page*/
        );

        $catalogo = $em->getRepository('IncentivesCatalogoBundle:Catalogos')->find($id);
        
        if($resumido){
            return $this->render('IncentivesCatalogoBundle:Catalogos:aprobarresumido.html.twig', 
            array('productos' => $pagination, 'id'=>$id, 'resumido'=>$resumido, 'form' => $form->createView(), 'catalogo'=>$catalogo));
        }else{
            return $this->render('IncentivesCatalogoBundle:Catalogos:aprobar.html.twig', 
            array('productos' => $pagination, 'id'=>$id, 'resumido'=>$resumido, 'form' => $form->createView(), 'catalogo'=>$catalogo));
        }
        
    }
    
    public function aprobarResumidoAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $query = $em->createQueryBuilder()
                ->select('pc','p','i') 
                ->from('IncentivesCatalogoBundle:Productocatalogo', 'pc')
                ->leftJoin('pc.producto','p')
                ->leftJoin('p.imagenproducto','i','WITH','i.estado=1')
                ->orderBy("pc.puntos");

        if ($this->get('security.authorization_checker')->isGranted('ROLE_EJEC')) {
            $condiciones = "pc.catalogos=".$id." AND pc.estadoAprobacion=1 ";
        }

        if ($this->get('security.authorization_checker')->isGranted('ROLE_COM')) {
            $condiciones = "pc.catalogos=".$id." AND pc.estadoAprobacion=2 ";
        }

        if ($this->get('security.authorization_checker')->isGranted('ROLE_CLI')) {
            $condiciones = "pc.catalogos=".$id." AND pc.estadoAprobacion=3 ";
        }

        if ($this->get('security.authorization_checker')->isGranted('ROLE_DIR') || $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') || $this->get('security.authorization_checker')->isGranted('ROLE_CAT')) {
            $condiciones = "pc.catalogos=".$id." AND (pc.estadoAprobacion=0 OR pc.estadoAprobacion IS NULL)";
        }
       
        $condiciones .= " AND pc.activo=1 ";
        
        $query->where($condiciones);

        $productos = $query->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $productos,
            $this->get('request')->query->get('page', 1)/*page number*/,
            20 /*limit per page*/
        );
        
        return $this->render('IncentivesCatalogoBundle:Catalogos:aprobarresumido.html.twig', 
            array('productos' => $pagination, 'id'=>$id));

    }
    
    public function aprobarcatalogoAction($accion, $id, $catalogo, $resumido = 0)
    {
        $em = $this->getDoctrine()->getManager();

        $arreglo=explode(",",$id);
        foreach ($arreglo as $key => $value) {
            if ($value!=""){
                $productos = $em->getRepository('IncentivesCatalogoBundle:Productocatalogo')->find($value);
                if ($accion=='autorizar'){
                    $estado = $em->getRepository('IncentivesCatalogoBundle:Estadocatalogo')->find("1");
                }elseif($accion=='cancelar'){
                    $estado = $em->getRepository('IncentivesCatalogoBundle:Estadocatalogo')->find("2");
		    $productos->setActivo(0);
                }     

                $usuario = $this->get('security.token_storage')->getToken()->getUser();

                if ($this->get('security.authorization_checker')->isGranted('ROLE_DIR') || $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                   $productos->setAproboOperaciones($estado);
                   $productos->setOperacionesUsuario($usuario);
                   
                   $estadoAprob = $em->getRepository('IncentivesCatalogoBundle:EstadoAprobacion')->find("1");
                   $productos->setEstadoAprobacion($estadoAprob);
                }  

                if ($this->get('security.authorization_checker')->isGranted('ROLE_EJEC')) {
                    $productos->setAproboComercial($estado);
                    $productos->setComercialUsuario($usuario);
                    
                    $estadoAprob = $em->getRepository('IncentivesCatalogoBundle:EstadoAprobacion')->find("2");
                    $productos->setEstadoAprobacion($estadoAprob);
                }

                if ($this->get('security.authorization_checker')->isGranted('ROLE_COM')) {
                    $productos->setAproboDirector($estado);
                    $productos->setDirectorUsuario($usuario);
                    
                    $estadoAprob = $em->getRepository('IncentivesCatalogoBundle:EstadoAprobacion')->find("3");
                    $productos->setEstadoAprobacion($estadoAprob);
                }

                if ($this->get('security.authorization_checker')->isGranted('ROLE_CLI')) {
                    $productos->setAproboCliente($estado);
                    $productos->setClienteUsuario($usuario);
                    
                    $estadoAprob = $em->getRepository('IncentivesCatalogoBundle:EstadoAprobacion')->find("4");
                    $productos->setEstadoAprobacion($estadoAprob);

                    $productos->setPuntos($productos->getPuntosTemporal());
                    $productos->setPrecio($productos->getPrecioTemporal());
                    $productos->setIncremento($productos->getIncrementoTemporal());
                    $productos->setLogistica($productos->getLogisticaTemporal());
                }

                $em->flush();
            }
        }

        if($resumido==1){
            return $this->redirect($this->generateUrl('catalogo_aprobar').'/'.$catalogo.'/1');
        }else{
            return $this->redirect($this->generateUrl('catalogo_aprobar').'/'.$catalogo);
        }
        
    }
    
    public function intervalosAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $intervalos = new Intervalos();
        $form = $this->createForm(IntervalosType::class, $intervalos);

        if ($request->isMethod('POST')) {
            $form->bind($request);
             $pro=($this->get('request')->request->get('intervalos'));
            if ($form->isValid()) {
                $id=($this->get('request')->request->get('id'));

                //verificar que el maximo y el minimo no esten dentro de otro intervalo
                $query = $em->createQueryBuilder()
                        ->select('i.id') 
                        ->from('IncentivesCatalogoBundle:Intervalos', 'i')
                        ->where("((i.minimo<=".$pro["minimo"]." AND i.maximo>=".$pro["minimo"].") OR (i.minimo<=".$pro["maximo"]." AND i.maximo>=".$pro["maximo"].")) AND i.catalogos=".$id);

                $existe = $query->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

                if($existe){
                    $this->get('session')->getFlashBag()->add('warning','Alguno de los valores ya se encuentra detro de un intervalo'
                );
                }else{

                    $catalogo = $em->getRepository('IncentivesCatalogoBundle:Catalogos')->find($id);
                    $intervalos->setCatalogos($catalogo);
                    $intervalos->setMinimo($pro["minimo"]);
                    $intervalos->setMaximo($pro["maximo"]);
                    $intervalos->setPuntos($pro["puntos"]);
                    $em->persist($intervalos);

                    $em->flush();

                    return $this->redirect($this->generateUrl('catalogo_datos').'/'.$id);
                }
            }
        }        

        $query = $em->createQueryBuilder()
                ->select('MAX(i.maximo) maximo') 
                ->from('IncentivesCatalogoBundle:Intervalos', 'i')
                ->where("i.catalogos=".$id);

        $minimo = $query->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        $minimo = 1 + @$minimo[0]['maximo']; 

        return $this->render('IncentivesCatalogoBundle:Catalogos:intervalos.html.twig', array(
                'form' => $form->createView(), 'id'=>$id, 'minimo' => $minimo
            ));
    }
    
    
    public function editarIntervalosAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $intervalos = $em->getRepository('IncentivesCatalogoBundle:Intervalos')->find($id);
        $catalogoId = $intervalos->getCatalogos()->getId();
        $form = $this->createForm(IntervalosType::class, $intervalos);

        if ($request->isMethod('POST')) {
            $form->bind($request);
             $pro=($this->get('request')->request->get('intervalos'));
            if ($form->isValid()) {
                $id=($this->get('request')->request->get('id'));

                //verificar que el maximo y el minimo no esten dentro de otro intervalo
                $query = $em->createQueryBuilder()
                        ->select('i.id') 
                        ->from('IncentivesCatalogoBundle:Intervalos', 'i')
                        ->where("((i.minimo<=".$pro["minimo"]." AND i.maximo>=".$pro["minimo"].") OR (i.minimo<=".$pro["maximo"]." AND i.maximo>=".$pro["maximo"].")) AND i.catalogos=".$catalogoId." AND i.id!=".$id);

                $existe = $query->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

                if($existe){
                    $this->get('session')->getFlashBag()->add('warning','Alguno de los valores ya se encuentra detro de un intervalo'
                );
                }else{

                    $catalogo = $em->getRepository('IncentivesCatalogoBundle:Catalogos')->find($catalogoId);
                    $intervalos->setCatalogos($catalogo);
                    $intervalos->setMinimo($pro["minimo"]);
                    $intervalos->setMaximo($pro["maximo"]);
                    $intervalos->setPuntos($pro["puntos"]);
                    $em->persist($intervalos);

                    $em->flush();

                    return $this->redirect($this->generateUrl('catalogo_datos').'/'.$catalogoId);
                }
            }
        }        

        return $this->render('IncentivesCatalogoBundle:Catalogos:intervalosEditar.html.twig', array(
                'form' => $form->createView(), 'id'=>$id, 'catalogo' => $catalogoId
            ));
    }

    public function imagenesCatalogoAction($catalogo)
    {
         $form = $this->createForm(ProductoType::class);

        $em = $this->getDoctrine()->getManager();
     
        $session = $this->get('session');
            
        $page = $this->get('request')->get('page');
        if(!$page) $page= 1;
            
        if($pro=($this->get('request')->request->get('producto'))){
            $page = 1;
            $session->set('filtros_imagenes', $pro);
        }

        $condicionesFiltro = "";

        if($filtros = $session->get('filtros_imagenes')){
               
               foreach($filtros as $Filtro => $valueF){
                   
                   if($valueF!=""){
                       if($Filtro=="categoria"){
                            $condicionesFiltro .= " AND c.id=".$valueF."";
                       }elseif($Filtro=="estado"){
                            $condicionesFiltro .= " AND i.estado=".$valueF."";
                       }elseif($Filtro=="precio"){
                            $condicionesFiltro .= " AND pc.precio=".$valueF."";
                       }else{
                            $condicionesFiltro .= " AND p.".$Filtro." LIKE '%".$valueF."%'";
                       }
                       
                   };
               } 
         }

        $query = $em->createQueryBuilder()
                ->select('pc','p','i','c') 
                ->from('IncentivesCatalogoBundle:Productocatalogo', 'pc')
                ->leftJoin('pc.producto','p')
                ->leftJoin('pc.categoria','c')
                ->leftJoin('p.imagenproducto','i','WITH','i.estado=1')
                ->orderBy("pc.puntos");

        $condiciones = "pc.catalogos=".$catalogo." AND pc.activo=1 AND pc.aproboCliente=1";

        if($this->get('request')->get('sort')){
            $query->orderBy($this->get('request')->get('sort'), $this->get('request')->get('direction'));    
        }

        $query->where($condiciones.$condicionesFiltro);
        $productos = $query->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $productos,
            $this->get('request')->query->get('page', 1)/*page number*/,
            20 /*limit per page*/
        );

        $catalogo = $em->getRepository('IncentivesCatalogoBundle:Catalogos')->find($catalogo);
        
        return $this->render('IncentivesCatalogoBundle:Catalogos:catalogoimagenes.html.twig', 
            array('productos' => $pagination, 'form' => $form->createView(), 'catalogo'=>$catalogo));
    }

   public function imagenesAction(Request $request, $id, $productos)
    {

        $em = $this->getDoctrine()->getManager();

        $catalogo = $em->getRepository('IncentivesCatalogoBundle:Catalogos')->find($id);

        $query = $em->createQueryBuilder()
                ->select('pc','p','i','c') 
                ->from('IncentivesCatalogoBundle:Productocatalogo', 'pc')
                ->leftJoin('pc.producto','p')
                ->leftJoin('pc.categoria','c')
                ->leftJoin('p.imagenproducto','i','WITH','i.estado=1')
                ->orderBy("pc.puntos");

        $strFilter = "pc.catalogos=".$id." AND pc.activo=1 AND pc.aproboCliente=1";

        if(isset($productos)){
            $productos = substr($productos, 0, -1);
            $strFilter .= " AND pc.id IN (".$productos.")";
        }
        
        $query->where($strFilter);
        $productos = $query->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        $files = array();

        foreach ($productos as $keyp => $valueP) {
            foreach ($valueP['producto']['imagenproducto'] as $keyI => $imagen) {
                array_push($files, $imagen['path']);             
            }
        }

        $zip = new \ZipArchive();
        $zipName = $catalogo->getId()."_".$catalogo->getNombre()."_".time().".zip";
        $zip->open($zipName,  \ZipArchive::CREATE);
        foreach ($files as $f) {
            $zip->addFromString(basename($f),  file_get_contents($f)); 
        }

        $zip->close();
        header('Content-Type', 'application/zip');
        header('Content-disposition: attachment; filename="' . $zipName . '"');
        header('Content-Length: ' . filesize($zipName));
        readfile($zipName);
    }
    
    public function productosproveedorAction($id)
    {
    
            // Create new PHPExcel object
            $Descarga = new PHPExcel();

            // Set document properties
            $Descarga->setActiveSheetIndex(0);
    
            $em = $this->getDoctrine()->getManager();
            $qb = $em->createQueryBuilder(); 
            $qb->select('c');
            $qb->from('IncentivesOperacionesBundle:Categoria','c');
            $categorias = $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

            $estado_array[] = '1 - Activo';
            $estado_array[] = '0 - Inactivo';

            
            $qb = $em->createQueryBuilder();
            $qb->select('pp','p','pe','c');
            $qb->from('IncentivesCatalogoBundle:Productoprecio','pp');
            $qb->Join('pp.producto','p');
            $qb->leftJoin('p.categoria','c');
            $qb->leftJoin('p.estado','pe');
            $str_filtro = 'pp.proveedor = '.$id;   
            $qb->where($str_filtro);
            $productos = $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
            
            $Descarga->getActiveSheet()
                        ->setCellValue('A1','CodInc')
                        ->setCellValue('B1','Nombre')
                        ->setCellValue('C1','Referencia')
                        ->setCellValue('D1','Marca')
                        ->setCellValue('E1','Descripción')
                        ->setCellValue('F1','Categoria')
                        ->setCellValue('G1','Estado')
                        ->setCellValue('H1','Precio');
            $fil=2;
            
            foreach ($productos as $key => $value) {
                
                    $Descarga->getActiveSheet()
                            ->setCellValue('A'.$fil, $value['producto']['codInc'])
                            ->setCellValue('B'.$fil, $value['producto']['nombre'])
                            ->setCellValue('C'.$fil, $value['producto']['referencia'])
                            ->setCellValue('D'.$fil, $value['producto']['marca'])
                            ->setCellValue('E'.$fil, $value['producto']['descripcion'])
                            ->setCellValue('F'.$fil, $value['producto']['categoria']['nombre'])
                            ->setCellValue('G'.$fil, $value['producto']['estado']['id'])
                            ->setCellValue('H'.$fil, $value['precio']);
                $fil++;
            }
                
            $objWriter = new PHPExcel_Writer_Excel2007($Descarga); 
            $objWriter->save('Productos_Proveedor.xlsx');  //send it to user, of course you can save it to disk also!
             // prepare BinaryFileResponse
            $basePath = $this->container->getParameter('kernel.root_dir').'/../web';
            $filename = 'Productos_Proveedor.xlsx';
            $objWriter->save($filename);  //send it to user, of course you can save it to disk also!
            $filePath = $basePath.'/'.$filename; 
             
            $response = new BinaryFileResponse($filePath);
            $response->trustXSendfileTypeHeader();
            $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $filename, iconv('UTF-8', 'ASCII//TRANSLIT', $filename));
            
            return $response;

    }
    
    public function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
        $sort_col = array();
        foreach ($arr as $key=> $row) {
            $sort_col[$key] = $row[$col];
        }
        array_multisort($sort_col, $dir, $arr);
    }    
    

}

