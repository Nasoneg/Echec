<?php
//src/Echec/ArticleBundle/Entity/Term.php

namespace Echec\ArticleBundle\Entity; 

use ED\BlogBundle\Interfaces\Model\BlogTermInterface;
use ED\BlogBundle\Model\Entity\Term as BaseTerm;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="echec_blog_term")
 * @ORM\Entity()
 * @UniqueEntity("slug")
 */
class Term extends BaseTerm implements BlogTermInterface
{
}