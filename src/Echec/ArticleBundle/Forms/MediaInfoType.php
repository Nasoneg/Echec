<?php

namespace Echec\ArticleBundle\Forms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MediaInfoType extends \ED\BlogBundle\Forms\MediaInfoType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'textarea', array(
                'attr' => array(
                    'class' => 'form-control form-control--lg',
                    'placeholder' => 'Enter caption',
                    'rows' => 2,
                )
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    }

    public function getName()
    {
        return 'media_info';
    }
}