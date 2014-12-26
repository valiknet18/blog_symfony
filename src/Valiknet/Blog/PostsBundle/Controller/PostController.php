<?php
namespace Valiknet\Blog\PostsBundle\Controller;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use Valiknet\Blog\PostsBundle\Entity\Post;
use Valiknet\Blog\PostsBundle\Entity\Tag;
use Valiknet\Blog\PostsBundle\Form\Type\AddPostType;
use Valiknet\Blog\PostsBundle\Form\Type\EditPostType;
use Valiknet\Blog\PostsBundle\Form\Type\AddCommentType;

class PostController extends Controller
{
    /**
     * @Template()
     * @return array
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('ValiknetBlogPostsBundle:Post')->findBy([], ['id' => 'DESC']);

        $paginator  = $this->get('knp_paginator');
        $posts = $paginator->paginate(
            $posts,
            $request->query->get('page', 1),
            3
        );

        return array(
            "posts" => $posts,
        );
    }

    /**
     * @Template()
     *
     * @param  Request                                                  $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $post = new Post();

        $form = $this->createForm(new AddPostType(), $post);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $tags = $form->get('tag')->getData();

            foreach ($tags as $tag) {
                $tagRequest = $em->getRepository('ValiknetBlogPostsBundle:Tag')
                    ->findByHashTag($tag);

                if (!$tagRequest) {
                    $newTag = new Tag();
                    $newTag->setHashTag($tag);

                    $post->addTag($newTag);

                    $em->persist($newTag);
                } else {
                    $post->addTag($tagRequest[0]);
                }
            }

            $em->persist($post);
            $em->flush();

            return $this->redirect($this->get('router')->generate('blog_home'));
        }

        return array(
            "form" => $form->createView(),
        );
    }

    /**
     * @Template()
     *
     * @param $slug
     * @return array
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
     * @Template()
     *
     * @param $slug
     * @param  Request                                                  $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
     public function editAction($slug, Request $request)
     {
         $em = $this->getDoctrine()->getManager();

         $post = $this->getDoctrine()
             ->getManager()
             ->getRepository('ValiknetBlogPostsBundle:Post')
             ->findOneBySlugPost($slug);

         if ($request->isMethod('POST')) {
             $this->get('valiknet.blog.postsbundle.services.post_handler')->removeTags($post);
         }

         $form = $this->createForm(new EditPostType($em), $post);

         $form->handleRequest($request);

         if ($form->isValid()) {
             $tags = $form->get('tag')->getData();

             $this->get('valiknet.blog.postsbundle.services.post_handler')
                 ->addTags($post, $tags, $em);

             $em->flush();

             return $this->redirect($this->get('router')->generate('blog_home'));
         }

         return array(
             "form" => $form->createView(),
         );
     }

    /**
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response|static
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
