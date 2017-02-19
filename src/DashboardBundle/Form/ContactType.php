<?php

namespace DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Doctrine\Common\Collections\ArrayCollection;
use DashboardBundle\Form\TagType;
use DashboardBundle\Entity\Tag;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\CallbackTransformer;
use Doctrine\Common\Persistence\ObjectManager;

class ContactType extends AbstractType
{
    private $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname')->add('name')->add('email')->add('phoneNumber')

        ->add('tags', TextType::class)

        ->add('description', CKEditorType::class, array(
          'config_name' => 'my_config',
        ))

        ->add('save', SubmitType::class, array('label' => 'Save'));


        $builder->get('tags')
            ->addModelTransformer(new CallbackTransformer(
                function ($tags) {
                  $tags = $tags->toArray();
                  if (count($tags) < 1)
                      return '';
                  else
                      return implode(',', $tags);
                },
                function ($string) {
                  $tags = new ArrayCollection();
                  $tag = strtok($string, ",");
                  while($tag !== false) {
                    $tagInDB = $this->om->getRepository('DashboardBundle:Tag')->findOneBy(array('name' => $tag));
                    if (!$tagInDB) {
                      $itag = new Tag();
                      $itag->setName($tag);
                    }
                    else{
                      $itag= $tagInDB;
                    }
                      if(!$tags->contains($itag))
                          $tags[] = $itag;
                      $tag = strtok(",");
                  }
                  return $tags;
                }
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DashboardBundle\Entity\Contact'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dashboardbundle_contact';
    }


}
