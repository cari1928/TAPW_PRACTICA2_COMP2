<?php

namespace Practica2Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Practica2Bundle\Entity\Country;
use Practica2Bundle\Form\CountryType;
use Practica2Bundle\Entity\Countrylanguage;
use Practica2Bundle\Form\CountrylanguageType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Doctrine\Common\Util\Debug;

class DefaultController extends Controller
{
    public function indexAction() {
        return $this->render('Practica2Bundle:Default:index.html.twig');
    }

    public function listaAction() {
        return $this->render('Practica2Bundle:Default:lista.html.twig');
    }

    public function listaplAction() {
        return $this->render('Practica2Bundle:Default:lista_pl.html.twig');
    }

    public function dataAction(){
        $em = $this->getDoctrine()->getManager();
        // $ens = $em->getRepository('Practica2Bundle:Country')->findBy(array(), array(), 100);
        $ens = $em->getRepository('Practica2Bundle:Country')->findBy(array('continent' => 'Asia'));

        $arrays = $this->createArray($ens, 'City');
        dump($arrays);
        $data = array('data'=>$arrays);

        $json_string = json_encode($data);

        return new Response ($json_string);
    }

    public function dataplAction(){
        $em = $this->getDoctrine()->getManager();
        $ens = $em->getRepository('Practica2Bundle:Countrylanguage')->findBy(array('isofficial' => 't'));

        $arrays = $this->createArray($ens, 'Country');
        dump($arrays);
        $data = array('data'=>$arrays);

        $json_string = json_encode($data);

        return new Response ($json_string);
    }

    public function nuevoAction(Request $request){
      $country = new Country();
      $form = $this->createForm(CountryType::class, $country);

      //para guardar un pais:
      $form->handleRequest($request); //el formulario administra el request
      if($form->isValid()){
        $em = $this->getDoctrine()->getEntityManager(); //se obtiene el manager
        $em->persist($country); //se indica que el obj pais es el que va a guardar
        $em->flush(); //se guarda
        return $this->redirect($this->generateUrl('practica2_lista')); //si esto se hace correctamente, se redirecciona a la página
      }

      return $this->render('Practica2Bundle:Default:nuevo.html.twig', array('formulario'=>$form->createView()));
    }

    public function nuevoplAction(Request $request){
      $countryLanguage = new Countrylanguage();
      $form = $this->createForm(CountrylanguageType::class, $countryLanguage);

      //para guardar una lengua:
      $form->handleRequest($request); //el formulario administra el request
      if($form->isValid()){
        $em = $this->getDoctrine()->getEntityManager(); //se obtiene el manager
        $em->persist($countryLanguage); //se indica que el obj lengua es el que va a guardar
        $em->flush(); //se guarda
        return $this->redirect($this->generateUrl('practica2_lista_pl')); //si esto se hace correctamente, se redirecciona a la página
      }

      return $this->render('Practica2Bundle:Default:nuevo_pl.html.twig', array('formulario'=>$form->createView()));
    }

    public function createArray($data, $entity){
      $array = array();
      foreach ($data as $p) {
        $tempCapital = "";
        $em = $this->getDoctrine()->getManager();

        if($entity == 'City') {
          $ens = $em->getRepository('Practica2Bundle:'.$entity)->findBy(array('id'=>$p->getCapital()->getId()));
        } elseif ($entity == 'Country') {
          $ens = $em->getRepository('Practica2Bundle:'.$entity)->findBy(array('code'=>$p->getCountrycode()->getCode()));
        }

        foreach ($ens as $city) { $tempCapital = $city->getName(); }

        if($entity == 'City') {
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

        } else {
          $temp = array(
            'language'=>$p->getLanguage(),      'isofficial'=>$p->getIsofficial(),
            'percentage'=>$p->getPercentage(),  'countrycode'=>$tempCapital,
          );
        }

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
      if(!$country){ throw $this->createNotFoundException('País no encontrado '.$id); } //por si no existe
      $form = $this->createForm(CountryType::class, $country);

      $form->handleRequest($request);
      if($form->isValid()){
        $em->persist($country);
        $em->flush();
        return $this->redirect($this->generateUrl('practica2_lista'));
      }

      return $this->render('Practica2Bundle:Default:editar.html.twig', array('formulario'=>$form->createView()));
    }

    public function eliminarAction($id) {
      $em = $this->getDoctrine()->getEntityManager();
      $country = $em->getRepository('Practica2Bundle:Country')->find($id); //se oobtiene el pais a eliminar

      if(!$country){ throw $this->createNotFoundException('País no encontrado '.$id); } //por si no existe

      $em->remove($country);
      $em->flush();
      return $this->redirect($this->generateUrl('practica2_lista'));
    }
}
