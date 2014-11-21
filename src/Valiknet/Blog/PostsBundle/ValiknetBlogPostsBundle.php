<?php

namespace Valiknet\Blog\PostsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ValiknetBlogPostsBundle extends Bundle
{
    public function boot()
    {
        $doctrine = $this->container->get('doctrine');

        $doctrine->getEntityManager()->getConfiguration()->addFilter(
            'soft-deleteable',
            'Gedmo\SoftDeleteable\Filter\SoftDeleteableFilter'
        );

        $em = $doctrine->getEntityManager();

        $em->getFilters()->enable('soft-deleteable');

    }
}
