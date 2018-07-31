<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Route("/tareas", name="tareas")
     */
    public function tareasAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Tarea');
        $tareas = $repository->findAllOrderedByDescripcion();

        return $this->render('default/pantalla_tareas.html.twig', array('tareas' => $tareas, 'mensaje'=> "hola") );
    }

    /**
    * @Route("/tarea/{id}", name="tarea", requirements={"id"="\d+"})
     */
    public function tareaAction($id)
    {

        $repository = $this->getDoctrine()->getRepository('AppBundle:Tarea');
        $url_atras = $this->generateUrl('homepage');
        $tarea = $repository->findOneById($id);
        return $this->render('default/tarea_unica.html.twig' , array('tarea' => $tarea, 'url_atras'=>$url_atras ) );
    }


     /**
     * @Route("/tareas.json", name="tareas_json")
     */
     public function tareasJsonTareaAction()
     {

        $repository = $this->getDoctrine()->getRepository('AppBundle:Tarea');
        $tareas = $repository->findAllOrderedByDescripcion();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $jsonContenido = $serializer->serialize($tareas , 'json');


       $response = new Response();
       $response->headers->set('Content-type', 'application/json');
       $response->setContent($jsonContenido);
       return $response;
    }

    /**
     * @Route("/tareas.xml", name="tareas_xml")
     */
     public function tareasXmlTareaAction()
     {

        $repository = $this->getDoctrine()->getRepository('AppBundle:Tarea');
        $tareas = $repository->findAllOrderedByDescripcion();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $jsonContenido = $serializer->serialize($tareas , 'xml');


       $response = new Response();
       $response->headers->set('Content-type', 'application/xml');
       $response->setContent($jsonContenido);
       return $response;


    }





}