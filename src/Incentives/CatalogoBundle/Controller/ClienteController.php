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
use Incentives\CatalogoBundle\Form\Type\ProgramaclienteType;

class ClienteController extends Controller
{
    /**
     * @Route("/cliente/nuevo")
     * @Template()
     */
    public function nuevoAction(Request $request)
    {
        $cliente = new Cliente();
        $programa = new Programa();

        $form = $this->createForm(ClienteType::class, $cliente);
                    
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager(); 
                
                $estado = $em->getRepository('IncentivesCatalogoBundle:Estados')->find(1);
                $cliente->setEstado($estado);
                $em->persist($cliente);

                $em->flush();

                return $this->redirect($this->generateUrl('cliente_datos').'/'.$cliente->getId());
            }
        }            

        return $this->render('IncentivesCatalogoBundle:Cliente:nuevo.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/cliente/editar")
     * @Template()
     */
    public function editarAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        if (isset($id)){
            $cliente = $em->getRepository('IncentivesCatalogoBundle:Cliente')->find($id);
            $form = $this->createForm(ClienteType::class, $cliente);
        }else{
            $form = $this->createForm(ClienteType::class);
            $cliente = new Cliente();
        }

        if ($request->isMethod('POST')) {
            $pro = $request->request->all()['cliente'];
            $form->handleRequest($request);


            if ($form->isValid()) {
                
                $pro = $request->request->all()['cliente'];
                $id = $request->request->all()['id'];
                $cliente = $em->getRepository('IncentivesCatalogoBundle:Cliente')->find($id);
                $cliente->setNombre($pro["nombre"]);
                $documento = $em->getRepository('IncentivesOperacionesBundle:Tipodocumento')->find($pro["tipodocumento"]);
                $cliente->setTipodocumento($documento);
                $cliente->setNumerodocumento($pro["numero_documento"]);
                $cliente->setDireccion($pro["direccion"]);
                $cliente->setTelefono($pro["telefono"]);
                $cliente->setCorreo($pro["correo"]);

                $em->persist($cliente);   
                $em->flush();

                return $this->redirect($this->generateUrl('cliente_datos').'/'.$id);
            }
        }

        return $this->render('IncentivesCatalogoBundle:Cliente:editar.html.twig', array(
            'form' => $form->createView(), 'cliente' => $cliente, 'id'=>$id,
        ));
    }

    /**
     * @Route("/cliente/datos/{id}")
     * @Template()
     */
    public function datosAction($id)
    {
        $repositoryc = $this->getDoctrine()
            ->getRepository('IncentivesCatalogoBundle:Cliente');

        $repositoryp = $this->getDoctrine()
            ->getRepository('IncentivesCatalogoBundle:Programa');

        $repositoryca = $this->getDoctrine()
            ->getRepository('IncentivesCatalogoBundle:Catalogos');

        $cliente= $repositoryc->find($id);
        $programa= $repositoryp->findByCliente($id);
        //var_dump(count($programa));
        if (count($programa)!=0){
			$catalogos= $repositoryca->findByPrograma($programa);
		}else{
			$catalogos=null;
		}

        return $this->render('IncentivesCatalogoBundle:Cliente:datos.html.twig', 
            array('cliente' => $cliente, 'id'=>$id, 'programa' => $programa, 'catalogos'=>$catalogos));
    }

    /**
     * @Route("/cliente")
     * @Template()
     */
    public function listadoAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('IncentivesCatalogoBundle:Cliente');

        $listado= $repository->findAll();
        
        return $this->render('IncentivesCatalogoBundle:Cliente:listado.html.twig', 
            array('listado' => $listado));
    }

    /**
     * @Route("/cliente/estado/{id}")
     * @Template()
     */
    public function estadoAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $cliente = $em->getRepository('IncentivesCatalogoBundle:Cliente')->find($id);

        if ($cliente->getEstado()->getId()=='1'){
            $estado = $em->getRepository('IncentivesCatalogoBundle:Estados')->find(2);
            $cliente->setEstado($estado);
        }else{
            $estado = $em->getRepository('IncentivesCatalogoBundle:Estados')->find(1);
            $cliente->setEstado($estado);
        }       
        $em->flush();
        
        return $this->redirect($this->generateUrl('cliente'));
    }

}
