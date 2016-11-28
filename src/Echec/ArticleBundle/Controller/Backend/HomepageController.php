<?php

namespace Echec\ArticleBundle\Controller\Backend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HomepageController extends \ED\BlogBundle\Controller\Backend\HomepageController
{
    /**
     * @Route("/", name="ed_blog_homepage_index")
     */
    public function indexAction()
    {
        $user = $this->getBlogUser();

        return $this->render("EchecArticleBundle:Homepage:index.html.twig", array());
    }

}