<?php

namespace Echec\ArticleBundle\Forms;



use Doctrine\ORM\EntityRepository;
use ED\BlogBundle\Model\Entity\Taxonomy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaxonomyType extends \ED\BlogBundle\Forms\TaxonomyType
{
    protected $dataClass;

    /**
     * @param $className of the form object
     */
    function __construct($dataClass)
    {
        $this->dataClass = $dataClass;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $object = $builder->getData();

        $builder
            ->add('term', 'edterm', array(
                'required' => true,
                'label' => 'Titre:',
                'attr' => array(
                    'class' => 'form-control form-control--lg margin--b',
                    'placeholder' => 'Entrez le titre de la catégorie'
                )
            ))
            ->add('description', 'text', array(
                'required' => false,
                'label' => 'Description:',
                'attr' => array(
                    'class' => 'form-control form-control--lg margin--b',
                    'placeholder' => 'Entrez la description de la catégorie'
                )
            ))
            ->add('parent', 'entity', array(
                'label' => 'Catégorie parent:',
                'required' => false,
                'class' => $this->dataClass,
                'placeholder' => 'Sélectionnez la catégorie parent',
                'query_builder' => function (EntityRepository $er) use ($object) {
                    if($object && $object->getId())
                    {
                        return $er->createQueryBuilder('c')
                            ->where('c.type = :type')
                            ->andWhere('c <> :object')
                            ->orderBy('c.id', 'DESC')
                            ->setParameter('type', Taxonomy::TYPE_CATEGORY)
                            ->setParameter('object', $object);
                    }
                    else
                    {
                        return $er->createQueryBuilder('c')
                            ->where('c.type = :type')
                            ->orderBy('c.id', 'DESC')
                            ->setParameter('type', Taxonomy::TYPE_CATEGORY);
                    }
                },
                'attr' => array(
                    'class' => 'form-control form-control--lg margin--b hide js-get-pretty-categories',
                    'data-empty-option' => 'Sélectionnez la catégorie parent'
                )
            ))
            ->add('type', 'hidden', array(
                'data' => Taxonomy::TYPE_CATEGORY
            ))
            ->add('save', 'submit', array(
                'attr' => array(
                    'class' => 'btn btn-md btn-primary btn-wide--xl flright--responsive-mob margin--t margin--b first-in-line'
                )
            ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "edtaxonomy";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->dataClass,
        ));
    }

}