<?php
namespace Valiknet\Blog\PostsBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method as Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use Valiknet\Blog\PostsBundle\Entity\Post;
use Valiknet\Blog\PostsBundle\Form\Type\AddPostType;
use Valiknet\Blog\PostsBundle\Form\Type\EditPostType;
use Valiknet\Blog\PostsBundle\Form\Type\AddCommentType;

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
            "posts" => $posts,
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

        $form->handleRequest($this->getRequest());

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->persist($post);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->get('router')->generate('blog_home'));
        }

        return array(
            "form" => $form->createView(),
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

        $form = $this->createForm(new AddCommentType());

        return array(
            "post" => $post,
            "form" => $form->createView(),
        );
    }

    /**
     * @Route("/post/{slug}/edit", name="edit_post")
     * @Method({"GET", "POST"})
     * @Template()
     */
     public function editAction($slug, Request $request)
     {
         $em = $this->getDoctrine()->getManager();

         $post = $this->getDoctrine()
             ->getManager()
             ->getRepository('ValiknetBlogPostsBundle:Post')
             ->findOneBySlugPost($slug);

         if ($request->isMethod('POST')) {
             $this->get('valiknet.blog.postsbundle.services.post_handler')
                 ->removeTags($post);
         }

         $form = $this->createForm(new EditPostType($em), $post);

         $form->handleRequest($request);

         if ($form->isValid()) {
             $em->flush();

             return $this->redirect($this->get('router')->generate('blog_home'));
         }

         return array(
             "form" => $form->createView(),
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

        $this->get('valiknet.blog.postsbundle.services.post_handler')
            ->removeTags($post);

        $em->remove($post);
        $em->flush();

        return JsonResponse::create(["code" => 200]);
    }
}
