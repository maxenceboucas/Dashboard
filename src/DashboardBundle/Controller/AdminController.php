<?php
namespace DashboardBundle\Controller;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as EasyAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use DashboardBundle\Entity\Contact;
use DashboardBundle\Form\TagType;

class AdminController extends EasyAdminController
{
    /**
     * @Route("/", name="easyadmin")
     */
    public function indexAction(Request $request)
    {
        return parent::indexAction($request);
    }

    public function createContactEntityFormBuilder(Contact $entity, $view)
    {
      $formBuilder = parent::createEntityFormBuilder($entity, $view);

      $formBuilder->remove('tags');

      $formBuilder->add('tags', CollectionType::class, array(
        'allow_add'    => true,
        'allow_delete' => true,
        'by_reference' => false,
        'entry_type' => TagType::class
      ));

      return $formBuilder;
    }
}
