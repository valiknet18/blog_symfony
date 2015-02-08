<?php

namespace Valiknet\BlogBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ValiknetBlogBundle extends Bundle
{
    public function boot()
    {
        $doctrine = $this->container->get('doctrine_mongodb');

        $doctrine->getManager()->getConfiguration()->addFilter(
            'soft-deleteable',
            'Gedmo\SoftDeleteable\Filter\SoftDeleteableFilter'
        );

        $em = $doctrine->getManager();

//        $em->getFilters()->enable('soft-deleteable');
    }
}
