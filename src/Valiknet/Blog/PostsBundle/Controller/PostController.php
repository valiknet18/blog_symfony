<?php
namespace Valiknet\Blog\PostsBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method as Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use Doctrine\ORM\Query\ResultSetMapping;


class PostController extends Controller
{

    /**
     * @Route("/", name="blog_home")
     * @Method({"GET"})
     * @Template("ValiknetBlogPostsBundle:Post:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sql = "SELECT t.id, t.hash_tag, COUNT(t.hash_tag) as countTag FROM ValiknetBlogPostsBundle:Tag AS t GROUP BY t.hash_tag ORDER BY countTag DESC";
        $tags = $em->createQuery($sql)->setMaxResults(10)->getResult();

        $posts = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Post')->findAll();

        return array(
            "posts" => $posts,
            "tags" => $tags
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

