<?php

namespace Echec\ArticleBundle\Forms;


use ED\BlogBundle\Transformers\PhotoToIdTransformer;
use ED\BlogBundle\Transformers\TagsToTextTransformer;
use Doctrine\ORM\EntityRepository;
use ED\BlogBundle\Model\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class ArticleType extends \ED\BlogBundle\Forms\ArticleType
{
    protected $dataClass;
    protected $userClass;
    protected $entityManager;
    protected $authorizationChecker;
    protected $taxonomyClass;

    function __construct($dataClass, $userClass, $taxonomyClass, $entityManager, AuthorizationChecker $authorizationChecker)
    {
        $this->dataClass = $dataClass;
        $this->entityManager = $entityManager;
        $this->userClass = $userClass;
        $this->taxonomyClass = $taxonomyClass;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $object = $builder->getData();
        $tagTransformer = new TagsToTextTransformer($this->entityManager->getManager(), $this->taxonomyClass);
        $photoTransformer = new PhotoToIdTransformer($this->entityManager->getManager());

        $builder
            ->add('title', 'text',
                array(
                    'required' => true,
                    'label' => 'Titre:',
                    'attr' => array(
                        'class' => 'form-control form-control--lg margin--b',
                        'placeholder' => 'Entrez le titre de l\'article'
                    )
                ))
            ->add('excerpt', 'textarea',
                array(
                    'required' => false,
                    'label' => 'Excerpt text:',
                    'attr' => array(
                        'class' => 'form-control form-control--lg margin--halfb',
                        'rows'  => 2,
                        'placeholder' => 'Enter excerpt text'
                    )
                ))
            ->add(
                $builder->create('excerptPhoto', 'hidden',
                    array(
                        'attr' => array('class' => 'sr-only js-excerpt-photo'),
                        'required' => false
                    ))->addModelTransformer($photoTransformer)
                )
            ->add('content', 'textarea',
                array(
                    'required' => false,
                    'label' => ' ',
                    'attr' => array(
                        'class' => 'tinymce'
                    )
                ))
            ->add('categories', 'entity', array(
                'class' => $this->taxonomyClass,
                'required' => false,
                'expanded' => true,
                'multiple' => true,
                'attr' => array(
                    'class' => 'js-get-pretty-categories',
                    'placeholder' => 'Sélectionnez une catégorie'
                )))
            ->add(
                $builder->create('tags','text', array(
                'required' => false,
                'attr' => array(
                    "class" => "form-control form-control--lg margin--halfb",
                    "placeholder" => "Entrez un tags",
                    "data-role" => "tagsinput"
                )))->addModelTransformer($tagTransformer)
                )
            ->add('metaData', 'collection', array(
                'type' =>  'article_meta',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            ->add('metaExtras', 'hidden', array(
                'mapped' => false
            ))
            ;

        if($this->authorizationChecker->isGranted('SWITCH_ARTICLE_AUTHOR'))
        {
            $builder
                ->add('author', 'entity', array(
                    'label' => 'Auteur:',
                    'required' => true,
                    'class' => $this->userClass,
                    'placeholder' => 'Sélectionnez un auteur',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('a')
                            ->where('a.roles like :type')
                            ->orderBy('a.username', 'ASC')
                            ->setParameter('type', '%ROLE_BLOG_USER%');

                    },
                    'attr' => array(
                        'class' => 'form-control form-control--lg color-placeholder',
                    )
                ));
        }
        if($this->authorizationChecker->isGranted('EDIT_PUBLISH_STATUS', $object))
        {
            $builder
                ->add('status', 'choice', array(
                    'label' => 'Statut:',
                    'choices' => array(
                        Article::STATUS_PUBLISHED => "Publié",
                        Article::STATUS_DRAFTED => "En attente"
                    ),
                    'required' => true,
                    'attr' => array(
                        "class" => "form-control form-control--lg margin--halfb",
                    ),
                    'data' => $object->getParent() ? $object->getParent()->getStatus() : Article::STATUS_DRAFTED
                ));
        }


        if(!$object->getParent())
        {
            //When creating new articles
            if($this->authorizationChecker->isGranted('PUBLISH_ARTICLE', $object))
            {
                $builder
                    ->add('publish', 'submit',
                        array(
                            'attr' => array('class' => 'btn btn-md btn-primary btn-wide--xl flright--responsive-mob margin--b first-in-line js-publish-article')
                        ));
            }

            $builder->add('save_draft', 'submit',
                    array(
                        'attr' => array('class' => 'btn btn-md btn-b-blue btn-wide--xl flright--responsive-mob margin--r')
                    ));
        }
        else
        {
            if($object && $object->getParent() && $object->getParent()->getStatus() == Article::STATUS_DRAFTED)
            {
                $builder
                    ->add('save', 'submit',
                        array(
                            'attr' => array('class' => 'btn btn-md btn-b-blue btn-wide--xl flright--responsive-mob margin--r')
                        ));

                if($this->authorizationChecker->isGranted('PUBLISH_ARTICLE', $object))
                {
                    $builder
                        ->add('publish', 'submit',
                            array(
                                'attr' => array('class' => 'btn btn-md btn-primary btn-wide--xl flright--responsive-mob margin--b first-in-line js-publish-article')
                            ));
                }
            }
            else
            {
                $builder->add('update', 'submit',
                    array(
                        'attr' => array('class' => 'btn btn-md btn-primary btn-wide--xl flright--responsive-mob margin--r')
                    ));
            }
        }


    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "article";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->dataClass,
        ));
    }


}