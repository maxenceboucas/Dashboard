<?php
namespace DashboardBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

use DashboardBundle\Entity\Contact;
use DashboardBundle\Form\ContactType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
      return $this->redirectToRoute('login');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function listContactAction(Request $request)
    {
      $query = $request->query->get('query');
      $em = $this->getDoctrine()->getManager();
      //$contacts = $em ->getRepository('DashboardBundle:Contact')->findAllQueryBuilder($query)->getQuery()->getResult() ;
      $contacts = $em ->getRepository('DashboardBundle:Contact')->findAll();
      return $this->render('DashboardBundle:list:contact.html.twig', array(
          'contacts' => $contacts,
          'query' => $query
      ));
    }

    /**
     * @Route("/contact/delete/{contact}", name="delete_contact",)
     */
    public function deleteContactAction(Contact $contact)
    {
      $em = $this->getDoctrine()->getManager();
      $em ->remove($contact);
      $em->flush();
      return $this->redirectToRoute('contact');
    }

    /**
     * @Route("/contact/edit/{contact}", name="edit_contact",)
     */
    public function editContactAction(Contact $contact,Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $contact = $em->getRepository('DashboardBundle:Contact')->find($contact);
      if (!$contact) {
        return $this->redirectToRoute('contact');
      }
      $form = $this->createForm(ContactType::class, $contact);

      if ($form->handleRequest($request)->isValid()) {
        $em->persist($contact);
        $em->flush();
        return $this->redirectToRoute('contact');
      }
      return $this->render('DashboardBundle:form:contact.html.twig', array(
            'form' => $form->createView(),
          ));
    }

    /**
     * @Route("/contact/new", name="new_contact",)
     */
    public function newContactAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $contact = new Contact();
      $form = $this->createForm(ContactType::class, $contact);

      if ($form->handleRequest($request)->isValid()) {
        $em->persist($contact);
        $em->flush();
        return $this->redirectToRoute('contact');
        }
          return $this->render('DashboardBundle:form:contact.html.twig', array(
            'form' => $form->createView(),
          ));
    }


    public function searchContactAction(Request $request)
    {
    }
}
