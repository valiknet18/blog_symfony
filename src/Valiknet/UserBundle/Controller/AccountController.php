<?php

namespace Valiknet\UserBundle\Controller;

use FOS\UserBundle\Document\User;
use Valiknet\BlogBundle\Controller\BlogAbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;

class AccountController extends BlogAbstractController
{
    /**
     * @param string $slug
     *
     * @return User $user
     *
     * @Template()
     */
    public function indexAccountAction($slug)
    {
        $user = $this->getMongoDbManager()
                    ->getRepository('ValiknetUserBundle:User')
                    ->findOneBySlug($slug);

        return [
            "user" => $user
        ];
    }

    /**
     * @param string $slug
     *
     * @return User $user
     *
     * @Template()
     */
    public function postsAccountAction($slug)
    {
        $user = $this->getMongoDbManager()
            ->getRepository('ValiknetUserBundle:User')
            ->findOneBySlug($slug);

        return [
            "user" => $user
        ];
    }

    /**
     * @param string $slug
     *
     * @return User $user
     *
     * @Template()
     */
    public function commentsAccountAction($slug)
    {
        $user = $this->getMongoDbManager()
            ->getRepository('ValiknetUserBundle:User')
            ->findOneBySlug($slug);

        return [
            "user" => $user
        ];
    }
}