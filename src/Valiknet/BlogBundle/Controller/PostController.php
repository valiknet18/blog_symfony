<?php
namespace Valiknet\BlogBundle\Controller;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use Valiknet\BlogBundle\BlogAbstractController;
use Valiknet\BlogBundle\Document\Post;
use Valiknet\BlogBundle\Document\Tag;
use Valiknet\BlogBundle\Form\Type\AddCommentType;
use Valiknet\BlogBundle\Form\Type\AddPostType;
use Valiknet\BlogBundle\Form\Type\EditPostType;

class PostController extends BlogAbstractController
{
    /**
     * @Template()
     * @return array
     */
    public function indexAction(Request $request)
    {
        $dm = $this->getMongoDbManager();

        $posts = $dm->getRepository('ValiknetBlogPostsBundle:Post')->findBy([], ['id' => 'DESC']);

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
        $dm = $this->getMongoDbManager();

        $post = new Post();

        $form = $this->createForm(new AddPostType(), $post);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $tags = $form->get('tag')->getData();

            foreach ($tags as $tag) {
                $tagRequest = $dm->getRepository('ValiknetBlogPostsBundle:Tag')
                    ->findByHashTag($tag);

                if (!$tagRequest) {
                    $newTag = new Tag();
                    $newTag->setHashTag($tag);

                    $post->addTag($newTag);

                    $dm->persist($newTag);
                } else {
                    $post->addTag($tagRequest[0]);
                }
            }

            $dm->persist($post);
            $dm->flush();

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
        $post = $this->getMongoDbManager()->getRepository('ValiknetBlogPostsBundle:Post')->findOneBy(['slugPost' => $slug]);

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
         $dm = $this->getMongoDbManager();

         $post = $this->getDoctrine()
             ->getManager()
             ->getRepository('ValiknetBlogPostsBundle:Post')
             ->findOneBySlugPost($slug);

         if ($request->isMethod('POST')) {
             $this->get('valiknet.blog.postsbundle.services.post_handler')->removeTags($post);
         }

         $form = $this->createForm(new EditPostType($dm), $post);

         $form->handleRequest($request);

         if ($form->isValid()) {
             $tags = $form->get('tag')->getData();

             $this->get('valiknet.blog.postsbundle.services.post_handler')
                 ->addTags($post, $tags, $dm);

             $dm->flush();

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
        $dm = $this->getMongoDbManager();

        $post = $dm->getRepository('ValiknetBlogPostsBundle:Post')->findBySlugPost($slug)[0];

        $this->get('valiknet.blog.postsbundle.services.post_handler')
             ->removeTags($post);

        $dm->remove($post);
        $dm->flush();

        return JsonResponse::create(["code" => 200]);
    }
}