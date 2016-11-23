<?php
//src/Echec/ArticleBundle/Entity/Settings.php

namespace Echec\ArticleBundle\Entity;

use ED\BlogBundle\Interfaces\Model\BlogSettingsInterface;
use ED\BlogBundle\Model\Entity\BlogSettings as BaseSettings;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="echec_blog_settings")
 * @ORM\Entity(repositoryClass="ED\BlogBundle\Model\Repository\BlogSettingsRepository")
 */
class Settings extends BaseSettings implements BlogSettingsInterface
{
}