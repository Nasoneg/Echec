<?php
//src/Echec/ArticleBundle/Entity/TaxonomyRelation.php

namespace Echec\ArticleBundle\Entity;  

use ED\BlogBundle\Interfaces\Model\TaxonomyRelationInterface;
use ED\BlogBundle\Model\Entity\TaxonomyRelation as BaseTaxonomyRelation;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="echec_blog_taxonomy_relation")
 * @ORM\Entity()
 */
class TaxonomyRelation extends BaseTaxonomyRelation implements TaxonomyRelationInterface
{
}