<?php
namespace Valiknet\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ValiknetUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}