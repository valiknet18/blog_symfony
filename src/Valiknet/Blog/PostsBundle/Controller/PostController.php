<?php
namespace Valiknet\Blog\PostsBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method as Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;


class PostController extends Controller{

    /**
     * @Route("/")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction()
    {
//        $em = $this->getDoctrine()->getRepository('');
        return new Response(
            "<h3>You are in index</h3>"
        );
    }

    /**
     * @Route("/post/add")
     * @Method({"POST"})
     */
    public function createPost()
    {

        return new Response(
            "<h3>You are in add post</h3>"
        );
    }
}

