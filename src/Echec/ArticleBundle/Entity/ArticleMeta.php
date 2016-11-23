<?php        
//src/Echec/ArticleBundle/Entity/ArticleMeta.php

namespace Echec\ArticleBundle\Entity;

use ED\BlogBundle\Interfaces\Model\ArticleMetaInterface;
use ED\BlogBundle\Model\Entity\ArticleMeta as BaseArticleMeta;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="echec_blog_article_meta")
 * @ORM\Entity()
 */
class ArticleMeta extends BaseArticleMeta implements ArticleMetaInterface
{
}