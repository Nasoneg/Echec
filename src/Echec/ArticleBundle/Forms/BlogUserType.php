<?php

namespace Echec\ArticleBundle\Forms;



use ED\BlogBundle\Handler\BlogUserHandler;
use ED\BlogBundle\Transformers\UserToEmailTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BlogUserType extends \ED\BlogBundle\Forms\BlogUserType
{
    protected $blogUserHandler;

    function __construct(BlogUserHandler $blogUserHandler)
    {
        $this->blogUserHandler = $blogUserHandler;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {

           $builder
               ->add('blogDisplayName', 'text', array(
                   'label' => 'Pseudo:',
                   'data' => isset($options['data']['blogDisplayName']) ? $options['data']['blogDisplayName'] : null,
                   'attr' => array(
                       'class' => 'form-control form-control--lg margin--b',
                       'placeholder' => 'Entrez le pseudo:'
                   )
               ))
               ->add('role', 'choice', array(
                'label' => 'Rôle ?',
                'expanded' => true,
                'choices' => $this->blogUserHandler->getBlogRolesArray(),
                'data' => isset($options['data']['role']) ? $options['data']['role'] : null
                ))
               ->add('Save', 'submit', array(
                'attr' => array(
                    'class' => 'btn btn-md btn-primary btn-wide--xl flright--responsive-mob margin--b'
                ))
            );
    }

    public function getName()
    {
        return "edblog_user";
    }
}