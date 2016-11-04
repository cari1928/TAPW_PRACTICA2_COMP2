<?php

namespace Practica2Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Practica2Bundle\Entity\Country;
use Practica2Bundle\Form\CountryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Doctrine\Common\Util\Debug;

class DefaultController extends Controller
{
    public function listaAction()
    {
        return $this->render('Practica2Bundle:Default:lista.html.twig');
    }

    public function dataAction(){
        $em = $this->getDoctrine()->getManager();
        // $ens = $em->getRepository('Practica2Bundle:Country')->findBy(array(), array(), 100);
        $ens = $em->getRepository('Practica2Bundle:Country')->findBy(array('continent' => 'Asia'));

        $arrays = $this->createArray($ens);
        dump($arrays);
        $data = array('data'=>$arrays);

        $json_string = json_encode($data);

        return new Response ($json_string);
    }

    public function nuevoAction(Request $request){
      $country = new Country();
      $form = $this->createForm(CountryType::class, $country);

      //para guardar un producto:
      $form->handleRequest($request); //el formulario administra el request
      if($form->isValid()){
        $em = $this->getDoctrine()->getEntityManager(); //se obtiene el manager
        $em->persist($country); //se indica que el obj producto es el que va a guardar
        $em->flush(); //se guarda
        return $this->redirect($this->generateUrl('practica2_lista')); //si esto se hace correctamente, se redirecciona a la página
      }

      return $this->render('Practica2Bundle:Default:nuevo.html.twig', array('formulario'=>$form->createView()));
    }

    public function createArray($data){
      $array = array();
      foreach ($data as $p) {
        $tempCapital = "";
        $em = $this->getDoctrine()->getManager();
        $ens = $em->getRepository('Practica2Bundle:City')->findBy(array('id'=>$p->getCapital()->getId()));

        foreach ($ens as $city) { $tempCapital = $city->getName(); }

        $temp = array(
          'code'=>$p->getCode(),                'name'=>$p->getName(),
          'continent'=>$p->getContinent(),      'region'=>$p->getRegion(),
          'surfacearea'=>$p->getSurfacearea(),  'indepyear'=>$p->getIndepyear(),
          'population'=>$p->getPopulation(),    'lifeexpectancy'=>$p->getLifeexpectancy(),
          'gnp'=>$p->getGnp(),                  'gnpold'=>$p->getGnpold(),
          'localname'=>$p->getLocalname(),      'governmentform'=>$p->getGovernmentform(),
          'headofstate'=>$p->getHeadofstate(),  'capital'=>$tempCapital,
          'code2'=>$p->getCode2()
        );
        array_push($array, $temp);
      }
      $array = $this->setArrays($array);
      return $array;
    }

    public function setArrays($data){
      $temp = array();
      for ($i=0; $i < sizeof($data); $i++) {
        array_push($temp, $data[$i]);
      }
      return $temp;
    }

    public function editarAction(Request $request, $id) {
      $em = $this->getDoctrine()->getEntityManager();
      $country = $em->getRepository('Practica2Bundle:Country')->find($id);
      if(!$country){ throw $this->createNotFoundException('Producto no encontrado'); } //por si no existe el producto
      $form = $this->createForm(CountryType::class, $country);

      $form->handleRequest($request);
      if($form->isValid()){
        $em->persist($country);
        $em->flush();
        return $this->redirect($this->generateUrl('practica2_lista'));
      }

      return $this->render('Practica2Bundle:Default:editar.html.twig', array('formulario'=>$form->createView()));
    }

    public function eliminarAction() {

    }
}
