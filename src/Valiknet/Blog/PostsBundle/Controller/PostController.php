<?php
namespace Valiknet\Blog\PostsBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method as Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use Doctrine\ORM\Query\ResultSetMapping;
use Valiknet\Blog\PostsBundle\Entity\Post;
use Valiknet\Blog\PostsBundle\Form\Type\AddPostType;

class PostController extends Controller
{
    /**
     * @Route("/", name="blog_home")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('ValiknetBlogPostsBundle:Post')->findBy([], ['id' => 'DESC']);

        return array(
            "posts" => $posts
        );
    }

    /**
     * @Route("/post/add", name="post_add_get")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function addAction(Request $request)
    {
        $tags = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('ValiknetBlogPostsBundle:Tag')
                    ->getHastTags();

        $post = new Post();

        $form = $this->createForm(new AddPostType($tags), $post);

        $form->handleRequest($request);

        if($form->isValid()) {
            $this->getDoctrine()->getManager()->persist($post);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->get('router')->generate('blog_home'));
        }

//        if($request->isMethod('POST')) {
//            $em = $this->getDoctrine()->getManager();
//
//            $post = new Post();
//
//            $post->setTitle($request->request->get('title'))
//                 ->setText($request->request->get('text'))
//                 ->setAuthor($request->request->get('author'));
//
//            $tags = $request->request->get('tags');
//
//            for($i = 0; $i < COUNT($tags); $i++) {
//                $tag = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Tag')->find($tags[$i]);
//
//                $tag->addPost($post);
//                $post->addTag($tag);
//            }
//
//            $em->persist($post);
//            $em->flush();
//
//            return $this->redirect($this->get('router')->generate('blog_home'));
//        }

        return array(
            "form" => $form->createView()
        );
    }

    /**
     * @Route("/post/{slug}/", name="view_post")
     * @Method({"GET"})
     * @Template()
     */
    public function viewAction($slug)
    {
        $post = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Post')->findOneBy(['slugPost' => $slug]);

        return array(
            "post" => $post
        );
    }

    /**
     * @Route("/post/{slug}/edit", name="edit_post")
     * @Method({"GET", "POST"})
     * @Template()
     */
     public function editAction($slug, Request $request)
     {
         if($request->isMethod('POST')) {
             $em = $this->getDoctrine()->getManager();

             $post = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Post')->findOneBySlugPost($slug);

             foreach($post->getTag() as $key=>$value) {
                 $post->removeTag($value);
                 $value->removePost($post);
             }

             $post->setTitle($request->request->get('title'));
             $post->setText($request->request->get('text'));
             $post->setAuthor($request->request->get('author'));

             $tags = $request->request->get('tags');
             for($i = 0; $i < COUNT($tags); $i++) {
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
     * @Route("/post/{slug}/delete", name="delete_post")
     * @Method({"DELETE"})
     */
    public function deletePostAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('ValiknetBlogPostsBundle:Post')->findBySlugPost($slug)[0];

        foreach($post->getTag() as $value) {
            $value->removePost($post);
            $post->removeTag($value);
        }

        $em->remove($post);
        $em->flush();

        return JsonResponse::create(["code" => 200]);
    }
}

