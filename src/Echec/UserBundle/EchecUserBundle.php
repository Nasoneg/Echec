<?php

namespace Echec\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EchecUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
