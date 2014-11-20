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
        $posts = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Post')->findAll();

        $tags = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Tag')
                                    ->createQueryBuilder('t')
                                    ->groupBy('t.hash_tag')
                                    ->setMaxResults(10)
                                    ->getQuery()
                                    ->getResult();


        uksort($tags, function($a, $b){
           if(COUNT($a['post']) > $b['post']){
               return $a;
           }
           else{
               return $b;
           }
        });

        return array(
            "posts" => $posts,
            "tags" => $tags
        );
    }

    /**
     * @Route("/post/add", name="post_add_get")
     * @Method({"GET"})
     * @Template("ValiknetBlogPostsBundle:Post:add.html.twig")
     */
    public function addPostAction()
    {
        return array(

        );
    }

    /**
     * @Route("/post/add", name="post_add_post")
     * @Method({"POST"})
     */
    public function createPostAction()
    {
        $this->redirect("blog_name");
    }

    /**
     * @Route("/post/view/{slug}", name="view_post")
     * @Method({"GET"})
     * @Template("ValiknetBlogPostsBundle:Post:view.html.twig")
     */
    public function viewPostACtion($slug)
    {
        $post = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Post')->findOneBy(['slug_post' => $slug]);

        return array(
            "post" => $post
        );
    }
}

