<?php

namespace Echec\ArticleBundle\Controller\Backend;

use ED\BlogBundle\Interfaces\Model\BlogUserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

class DefaultController extends \ED\BlogBundle\Controller\Backend\DefaultController
{
    public function getBlogUser()
    {
        $user = $this->getLoggedUser();

        if($this->container->get('security.authorization_checker')->isGranted('ROLE_BLOG_USER') === false)
            throw new AccessDeniedException('Ce contenu est actuellement indisponible, vous n\'avez peut être pas les droits nécessaires.');

        if(!$user->hasRole('ROLE_BLOG_CONTRIBUTOR') && !$user->hasRole('ROLE_BLOG_AUTHOR') && !$user->hasRole('ROLE_BLOG_EDITOR') && !$user->hasRole('ROLE_BLOG_ADMIN'))
            throw new AccessDeniedException('Désolé, vous n\'avez pas les droits pour accèder à cette page');

        return $user;
    }

    public function checkCommentsAdministrator()
    {
        if($this->container->get('security.authorization_checker')->isGranted('ADMINISTRATE_COMMENTS') === false)
            throw new AccessDeniedException('Ce contenu est actuellement indisponible, vous n\'avez peut être pas les droits nécessaires.');
    }

    public function getBlogAdministrator()
    {
        $user = $this->getLoggedUser();

        if($this->container->get('security.authorization_checker')->isGranted('ROLE_BLOG_ADMIN') === false)
            throw new AccessDeniedException('Ce contenu est actuellement indisponible, vous n\'avez peut être pas les droits nécessaires.');

        return $user;
    }

    private function getLoggedUser()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('Veuillez vous connecter.');
        }

        return $user;
    }

    public function getDefaultBlogRole( BlogUserInterface $user=null)
    {
        if(!$user)
            $user = $this->getUser();

        return $this->get('ed_blog.handler.blog_user_handler')->getDefaultBlogRole($user);
    }
}
