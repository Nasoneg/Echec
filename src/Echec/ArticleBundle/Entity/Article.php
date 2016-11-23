<?php     
//src/Echec/ArticleBundle/Entity/Article.php

namespace Echec\ArticleBundle\Entity;

use ED\BlogBundle\Interfaces\Model\ArticleInterface;
use ED\BlogBundle\Model\Entity\Article as BaseArticle;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="echec_blog_article")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="ED\BlogBundle\Model\Repository\ArticleRepository")
 */
class Article extends BaseArticle implements ArticleInterface{
	 
}