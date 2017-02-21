<?php

namespace Incentives\CatalogoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Incentives\CatalogoBundle\Entity\Cliente;
use Incentives\CatalogoBundle\Form\Type\ClienteType;
use Incentives\CatalogoBundle\Entity\Programa;
use Incentives\CatalogoBundle\Form\Type\ProgramaType;
use Incentives\CatalogoBundle\Form\Type\ProgramanuevoType;
use Incentives\CatalogoBundle\Entity\Catalogos;
use Incentives\CatalogoBundle\Form\Type\CatalogosType;
use Incentives\CatalogoBundle\Form\Type\CatalogoprogramaType;


class ProgramaController extends Controller
{
    /**
     * @Route("/programa/nuevo")
     * @Template()
     */
    public function nuevoAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $programa = new Programa();
        $catalogo = new Catalogos();
        if (isset($id)){
            $cliente = $em->getRepository('IncentivesCatalogoBundle:Cliente')->find($id);
            $form = $this->createForm(ProgramaType::class, $programa);
        }else{
            $cliente = new Cliente();
            $form = $this->createForm(ProgramanuevoType::class, $programa);
        }   
                    
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $id = $request->request->all()['id'];
                $pro = $request->request->all()['programanuevo'];

                //if(isset($pro['programanuevo'])) $pro = $pro['programanuevo']; else $pro = $pro['programa'];

                if ($id==0){
                    $id=$programa->getCliente()->getId();
                }
                $cliente = $em->getRepository('IncentivesCatalogoBundle:Cliente')->find($id);
                // realiza alguna acción, tal como guardar la tarea en la base de datos
                if (0 != count($programa->getCatalogo())) {
                    foreach ($programa->getCatalogo() as $catalogo) {
                        $catalogo->setPrograma($programa);
                        $programa->addCatalogo($catalogo);
                        $em->persist($catalogo);
                    }
                }    
                $programa->setCliente($cliente);
                $centroCostos = $em->getRepository('IncentivesCatalogoBundle:CentroCostos')->find($pro["centroCostos"]);
                $programa->setCentroCostos($centroCostos);
                $programa->setApiSecret(SHA1(time()));
                $programa->setApiKey(SHA1($pro["nombre"]));
                $em->persist($programa);

                $em->flush();

                return $this->redirect($this->generateUrl('programa_datos').'/'.$programa->getId());
            }
        }            

        if ($id!=0){
            return $this->render('IncentivesCatalogoBundle:Programa:nuevo.html.twig', array(
                'form' => $form->createView(), 'id'=>$id
            ));
        }else{
            return $this->render('IncentivesCatalogoBundle:Programa:nuevo1.html.twig', array(
                'form' => $form->createView(), 'id'=>$id
            ));
        }
    }

    /**
     * @Route("/cliente/editar")
     * @Template()
     */
    public function editarAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        if (isset($id)){
            $programa = $em->getRepository('IncentivesCatalogoBundle:Programa')->find($id);
            $form = $this->createForm(ProgramaType::class, $programa);
        }else{
            $form = $this->createForm(ProgramaType::class);
            $programa = new Programa();
        }

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);


            if ($form->isValid()) {                
                $pro = $request->request->all()['programa'];
                $id = $request->request->all()['id'];
                $programa = $em->getRepository('IncentivesCatalogoBundle:Programa')->find($id);
                $programa->setNombre($pro["nombre"]);
                $programa->setDescripcion($pro["descripcion"]);
                $fecha = date_create($pro["fechainicio"]);
                $programa->setFechainicio($fecha);
                $fecha2 = date_create($pro["fechafin"]);
                $programa->setFechafin($fecha2);
                $programa->setDiasentrega(($pro["diasentrega"])? $pro["diasentrega"]: 0);
                $programa->setIva($pro["iva"]);
                $centroCostos = $em->getRepository('IncentivesCatalogoBundle:CentroCostos')->find($pro["centroCostos"]);
                $programa->setCentroCostos($centroCostos);
                if(isset($pro["apiKey"]) && $pro["apiKey"]!="") $programa->setApiKey($pro["apiKey"]);

                $em->persist($programa);   
                $em->flush();

                //$conn = $this->get('database_connection'); 

                //$excelcar = $conn->insert('Programa', array('fechainicio' => date($pro["fechainicio"]["year"]."-". $pro["fechainicio"]["month"]."-".$pro["fechainicio"]["day"])));

                return $this->redirect($this->generateUrl('programa_datos').'/'.$id);
            }
        }


        return $this->render('IncentivesCatalogoBundle:Programa:editar.html.twig', array(
            'form' => $form->createView(), 'programa' => $programa, 'id'=>$id,
        ));
    }

    /**
     * @Route("/cliente/datos/{id}")
     * @Template()
     */
    public function datosAction($id)
    {
        $repositoryp = $this->getDoctrine()
            ->getRepository('IncentivesCatalogoBundle:Programa');

        $repositoryca = $this->getDoctrine()
            ->getRepository('IncentivesCatalogoBundle:Catalogos');

        $programa= $repositoryp->find($id);
        $catalogos= $repositoryca->findByPrograma($programa);


        return $this->render('IncentivesCatalogoBundle:Programa:datos.html.twig', 
            array( 'id'=>$id, 'programa' => $programa, 'catalogos'=>$catalogos));
    }

    /**
     * @Route("/cliente")
     * @Template()
     */
    public function listadoAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('IncentivesCatalogoBundle:Programa');

        $listado= $repository->findAll();

        return $this->render('IncentivesCatalogoBundle:Programa:listado.html.twig', 
            array('listado' => $listado));
    }

    /**
     * @Route("/programa/estado/{id}")
     * @Template()
     */
    public function estadoAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $programa = $em->getRepository('IncentivesCatalogoBundle:Programa')->find($id);

        if ($programa->getEstado()->getId() == 1){
            $estado = $em->getRepository('IncentivesCatalogoBundle:Estados')->find(2);
            $programa->setEstado($estado);

            $estadoCatalogo = $em->getRepository('IncentivesCatalogoBundle:EstadoCatalogo')->find(2);
            
            $query = $em->createQueryBuilder()
                    ->select('pr') 
                    ->from('IncentivesCatalogoBundle:Premios', 'pr')
                    ->leftJoin('pr.catalogos','c');
                    
            $query->where("c.programa=".$id);
                
            $productos = $query->getQuery()->getResult();
            
            foreach($productos as $keyP => $valueP){
                
                $valueP->setEstado($estadoCatalogo);
                $em->persist($valueP);
                $em->flush();
            }
            
        }else{
            $estado = $em->getRepository('IncentivesCatalogoBundle:Estados')->find(1);
            $programa->setEstado($estado);
        }       
        $em->flush();
        
        return $this->redirect($this->generateUrl('programa'));
    }

}
