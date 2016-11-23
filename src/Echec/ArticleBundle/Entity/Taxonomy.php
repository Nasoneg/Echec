<?php
//src/Echec/ArticleBundle/Entity/Taxonomy.php

namespace Echec\ArticleBundle\Entity; 

use ED\BlogBundle\Interfaces\Model\BlogTaxonomyInterface;
use ED\BlogBundle\Model\Entity\Taxonomy as BaseTaxonomy;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="echec_blog_taxonomy")
 * @ORM\Entity(repositoryClass="ED\BlogBundle\Model\Repository\TaxonomyRepository")
 */
class Taxonomy extends BaseTaxonomy implements BlogTaxonomyInterface
{
}