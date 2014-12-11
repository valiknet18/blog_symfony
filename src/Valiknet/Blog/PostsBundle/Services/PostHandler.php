<?php
namespace Valiknet\Blog\PostsBundle\Services;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\Form;
use Valiknet\Blog\PostsBundle\Entity\Post;

class PostHandler
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getRequest()
    {
        return $this->container->get('request');
    }

    public function getDoctrine()
    {
        return $this->container->get('doctrine');
    }

    public function handleAddPost(Form $form, Post $post)
    {
        return false;
    }
}
