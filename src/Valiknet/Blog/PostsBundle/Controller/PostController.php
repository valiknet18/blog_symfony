<?php
namespace Valiknet\Blog\PostsBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method as Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;


class PostController extends Controller{

    /**
     * @Route("/", name="blog_home")
     * @Method({"GET"})
     * @Template("ValiknetBlogPostsBundle:Post:index.html.twig")
     */
    public function indexAction()
    {
        $posts = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Post')->findAll();

        return array(
            "posts" => $posts
        );
    }

    /**
     * @Route("/post/add")
     * @Method({"POST"})
     */
    public function createPostAction()
    {

        return new Response(
            "<h3>You are in add post</h3>"
        );
    }
}

