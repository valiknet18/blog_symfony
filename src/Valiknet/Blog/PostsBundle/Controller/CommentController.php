<?php
namespace Valiknet\Blog\PostsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use Valiknet\Blog\PostsBundle\Entity\Comment;
use Valiknet\Blog\PostsBundle\Form\Type\AddCommentType;

class CommentController extends Controller
{
    /**
     * @param $slug
     * @param  Request      $request
     * @return JsonResponse
     */
    public function createCommentAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $comment = new Comment();

        $form = $this->createForm(new AddCommentType(), $comment);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $comment->setPost($this->getDoctrine()->getManager()->getRepository('ValiknetBlogPostsBundle:Post')->findOneBySlugPost($slug));

            $em->persist($comment);
            $em->flush();

            $post = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('ValiknetBlogPostsBundle:Post')
                    ->findBySlugPost($slug);

            $comments = $this->get('valiknet.blog.postsbundle.services.comment_handler')->handleAddComment($post);

            return new JsonResponse([$comments]);
        }

        return new JsonResponse([], 500);
    }

    /**
     * @Template()
     *
     * @param $count
     * @return array
     */
    public function lastAction($count)
    {
        $comments = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Comment')->findBy([], ['id' => 'DESC'], $count);

        return array(
            "comments" => $comments,
        );
    }
}
