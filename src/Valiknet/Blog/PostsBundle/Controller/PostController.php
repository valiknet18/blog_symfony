<?php
namespace Valiknet\Blog\PostsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method as Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use Doctrine\ORM\Query\ResultSetMapping;
use Valiknet\Blog\PostsBundle\Entity\Post;


class PostController extends Controller
{

    /**
     * @Route("/", name="blog_home")
     * @Method({"GET"})
     * @Template("ValiknetBlogPostsBundle:Post:index.html.twig")
     */
    public function indexAction()
    {
        $posts = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Post')->findBy([], ['id' => 'DESC']);

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
     * @Method({"GET", "POST"})
     * @Template("ValiknetBlogPostsBundle:Post:add.html.twig")
     */
    public function addPostAction(Request $request)
    {
        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();

            $post = new Post();

            $rq = $request->request;

            $post->setTitle($rq->get('title'))
                 ->setText($rq->get('text'))
                 ->setAuthor($rq->get('author'));

            $tags = $rq->get('tags');

            for($i = 0; $i < COUNT($tags); $i++){
                $tag = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Tag')->find($tags[$i]);

                $tag->addPost($post);
                $post->addTag($tag);
            }


            $em->persist($post);
            $em->flush();

            return $this->redirect($this->get('router')->generate('blog_home'));
        }

        return array(
            "tags" => $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Tag')->findAll()
        );
    }

    /**
     * @Route("/post/view/{slug}", name="view_post")
     * @Method({"GET"})
     * @Template("ValiknetBlogPostsBundle:Post:view.html.twig")
     */
    public function viewPostAction($slug)
    {
        $post = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Post')->findOneBy(['slug_post' => $slug]);

        return array(
            "post" => $post
        );
    }
}

