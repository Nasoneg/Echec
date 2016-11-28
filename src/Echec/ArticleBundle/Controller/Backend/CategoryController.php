<?php

namespace Echec\ArticleBundle\Controller\Backend;

use ED\BlogBundle\Handler\Pagination;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends \ED\BlogBundle\Controller\Backend\CategoryController
{
    /**
     * @Route("/category/list", name="ed_blog_category_list")
     */
    public function listAction(Request $request)
    {
        $user = $this->getBlogAdministrator();
        $orderBy = $request->get('orderby', null);
        $order = $request->get('order', null);

        $paginator = $this->get('ed_blog.paginator');
        $response = $paginator->paginate(
            ($orderBy ) ?  $this->get('app_repository_taxonomy')->getSortableQuery($orderBy, $order) : $this->get('app_repository_taxonomy')->getAllParentCategories(),
            'EchecArticleBundle:Taxonomy/Category:list' . (($orderBy ) ? '_sortable' : '')  ,
            'EchecArticleBundle:Taxonomy:pagination',
            array(
                'orderBy' => $orderBy,
                'order' => $order
            ),
            Pagination::DOZEN,
            null,
            $paginationTemplate = 'EchecArticleBundle:Taxonomy:pagination.html.twig',
            array(),
            null
        );

        return $response;
    }

    /**
     * @Route("/category/create", name="ed_blog_category_create")
     */
    public function createAction(Request $request)
    {
        $user = $this->getBlogAdministrator();

        $form = $this->createForm('edtaxonomy', $this->get('taxonomy_generator')->getObject());

        if($request->isMethod('post'))
        {
            $form->handleRequest($request);

            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();

                $em->persist($form->getData());
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Category created successfully.');
                return $this->redirectToRoute('ed_blog_category_list');
            }
        }

        return $this->render("@EDBlog/Taxonomy/Category/create.html.twig", array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/category/{slug}/edit", name="ed_blog_category_edit")
     */
    public function editAction(Request $request, $slug)
    {
        $user = $this->getBlogAdministrator();
        $taxonomy = $this->get('app_repository_taxonomy')->findBySlug($slug);
        if(!$taxonomy)
            throw new NotFoundHttpException("Désolé, la ressource ne peut pas être trouvée.");

        $form = $this->createForm('edtaxonomy', $taxonomy);

        if($request->isMethod('post'))
        {
            $form->handleRequest($request);

            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();

                $em->persist($form->getData());
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Catégorie modifiée avec succès.');
                return $this->redirectToRoute('ed_blog_category_list');
            }
        }

        return $this->render("@EDBlog/Taxonomy/Category/edit.html.twig", array(
            'form' => $form->createView(),
            'slug' => $slug
        ));
    }

    /**
     * @Route("/category/{slug}/remove", name="ed_blog_category_delete")
     */
    public function deleteAction($slug)
    {
        $user = $this->getBlogAdministrator();
        $taxonomy = $this->get('app_repository_taxonomy')->findBySlug($slug);
        if(!$taxonomy)
            throw new NotFoundHttpException("Désolé, la ressource ne peut pas être trouvée.");

        $em = $this->getDoctrine()->getManager();

        $em->remove($taxonomy);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Catégorie supprimée avec succès');
        return $this->redirectToRoute('ed_blog_category_list');
    }

    /**
     * @Route("/category/{template}/pretty", name="ed_blog_category_all_pretty", defaults={ "template"="all"})
     */
    public function allPrettyAction(Request $request, $template)
    {
        $categories = $this->get('app_repository_taxonomy')->getAllParentCategories();

        $selected = $request->get('select', array());

        return new JsonResponse(array(
            'success' => true,
            'html' => $this->renderView("@EDBlog/Taxonomy/Category/pretty" . ($template == 'all' ? "" : "_$template") . ".html.twig", array(
                'categories' => $categories,
                'selected' => $selected
                ))
        ));
    }
}