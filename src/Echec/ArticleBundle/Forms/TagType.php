<?php

namespace Echec\ArticleBundle\Forms;



use ED\BlogBundle\Model\Entity\Taxonomy;
use Symfony\Component\Form\FormBuilderInterface;

class TagType extends \ED\BlogBundle\Forms\TagType
{
    function __construct($dataClass)
    {
        parent::__construct($dataClass);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('term', 'edterm', array(
                'required' => true,
                'label' => 'Titre:',
                'attr' => array(
                    'class' => 'form-control form-control--lg margin--b',
                    'placeholder' => 'Entrez le titre du tag'
                )
            ))
            ->add('description', 'text', array(
                'required' => false,
                'label' => 'Description:',
                'attr' => array(
                    'class' => 'form-control form-control--lg margin--b',
                    'placeholder' => 'Entrez la description du tag'
                )
            ))
            ->add('type', 'hidden', array(
                'data' => Taxonomy::TYPE_TAG
            ))
            ->remove('parent');
    }

    public function getName()
    {
        return "edtag";
    }


}