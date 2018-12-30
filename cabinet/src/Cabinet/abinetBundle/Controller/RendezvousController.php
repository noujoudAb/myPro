<?php
/**
 * Created by PhpStorm.
 * User: Riadh
 * Date: 12/14/2018
 * Time: 4:27 AM
 */

namespace Cabinet\abinetBundle\Controller;


use AppBundle\Entity\Rdv;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RendezvousController extends Controller
{
 public function ajouterRDVAction(Request $request){
$rdv = new Rdv();
$us = $this->getUser();
$em = $this->getDoctrine()->getManager();
$user =$em->getRepository('AppBundle:User')->find($us->getId());
     $form = $this->createForm('AppBundle\Form\RdvType', $rdv);
     $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid()) {
        $rdv->setIdUser($user);

         $em->persist($rdv);

         $em->flush();

         return $this->redirectToRoute('cabinetabinet_show');
     }
return $this->render('@Cabinetabinet/RDV/Addrdv.html.twig',array('f'=>$form->createView()));

 }
 public function afficherrdvAction(){
     $em = $this->getDoctrine()->getManager();
     $rdv = $em->getRepository('AppBundle:Rdv')->findAll();
     return $this->render('@Cabinetabinet/RDV/listrdv.html.twig',array('rdv'=>$rdv));

 }
 public  function  updateRDVAction(Request $request){
     $idrdv = $request->get('id');

     $us = $this->getUser();
     $em = $this->getDoctrine()->getManager();
     $user =$em->getRepository('AppBundle:User')->find($us->getId());
     $rdv = $em->getRepository('AppBundle:Rdv')->find($idrdv);
     $form = $this->createForm('AppBundle\Form\RdvType', $rdv);
     $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid()) {
         $rdv->setIdUser($user);

         $em->persist($rdv);

         $em->flush();

         return $this->redirectToRoute('cabinetabinet_show');
     }
     return $this->render('@Cabinetabinet/RDV/modifrdv.html.twig',array('f'=>$form->createView()));

 }
    public  function  deleteRDVAction(Request $request){
        $idrdv = $request->get('id');
        $em = $this->getDoctrine()->getManager();

        $rdv = $em->getRepository('AppBundle:Rdv')->find($idrdv);

        $em->remove($rdv);

        $em->flush();
        return $this->redirectToRoute('cabinetabinet_show');
    }
}