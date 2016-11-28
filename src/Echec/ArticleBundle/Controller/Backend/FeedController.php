<?php

namespace Echec\ArticleBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class FeedController extends \ED\BlogBundle\Controller\Backend\FeedController
{
    /**
     * Generate the article feed
     */
    public function feedAction($type)
    {
        $articles = $this->get('app_repository_article')->getActiveArticles();

        $feed = $this->get('eko_feed.feed.manager')->get('article');
        $feed->addFromArray($articles);

        return new Response($feed->render($type)); // or 'atom'
    }
}