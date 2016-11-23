<?php
//src/Echec/ArticleBundle/Entity/Comment.php

namespace Echec\ArticleBundle\Entity;

use ED\BlogBundle\Interfaces\Model\CommentInterface;
use ED\BlogBundle\Model\Entity\Comment as BaseComment;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="echec_blog_comment")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="ED\BlogBundle\Model\Repository\CommentRepository")
 */
class Comment extends BaseComment implements CommentInterface
{
}           