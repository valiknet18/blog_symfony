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
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('ValiknetBlogPostsBundle:Post')->findBy([], ['id' => 'DESC']);

        $tags = $em->getRepository('ValiknetBlogPostsBundle:Tag')
                                    ->createQueryBuilder('t')
                                    ->groupBy('t.hashTag')
                                    ->setMaxResults(10)
                                    ->getQuery()
                                    ->getResult();




        usort($tags, function($a, $b){
            if(COUNT($a->getPost()) == COUNT($b->getPost())){
                return 0;
            }

            return (COUNT($a->getPost()) > COUNT($b->getPost()))? -1: 1;
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

            $post->setTitle($request->request->get('title'))
                 ->setText($request->request->get('text'))
                 ->setAuthor($request->request->get('author'));

            $tags = $request->request->get('tags');

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
        $post = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Post')->findOneBy(['slugPost' => $slug]);

        return array(
            "post" => $post
        );
    }

    /**
     * @Route("/post/edit/{slug}", name="edit_post")
     * @Method({"GET", "POST"})
     * @Template("ValiknetBlogPostsBundle:Post:edit.html.twig")
     */
     public function editPostAction($slug, Request $request)
     {
         if($request->isMethod('POST')){
             $em = $this->getDoctrine()->getManager();

             $post = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Post')->findOneBySlugPost($slug);

             foreach($post->getTag() as $key=>$value){
                 $post->removeTag($value);
                 $value->removePost($post);
             }

             $post->setTitle($request->request->get('title'));
             $post->setText($request->request->get('text'));
             $post->setAuthor($request->request->get('author'));

             $tags = $request->request->get('tags');
             for($i = 0; $i < COUNT($tags); $i++){
                 $tag = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Tag')->find($tags[$i]);
                 $tag->addPost($post);

                 $post->addTag($tag);
             }

             $em->flush();

             return $this->redirect($this->get('router')->generate('blog_home'));
         }

         $post = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Post')->findOneBySlugPost($slug);
         $tags = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Tag')->findAll();

         return array(
             "post" => $post,
             "tags" => $tags
         );
     }

    /**
     * @Route("/post/delete/{id}", name="delete_post")
     * @Method({"DELETE"})
     */
    public function deletePostAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Post')->find($id);

        foreach($post->getTag() as $value){
            $value->removePost($post);
            $post->removeTag($value);
        }

        $em->remove($post);
        $em->flush();

        return new Response(
            json_encode(
                array(
                    "code" => 200
                )
            )
        );
    }
}

