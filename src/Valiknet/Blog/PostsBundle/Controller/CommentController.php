<?php
namespace Valiknet\Blog\PostsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method as Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use Valiknet\Blog\PostsBundle\Entity\Comment;
use Valiknet\Blog\PostsBundle\Form\Type\AddCommentType;

/**
 * @Route("/comment")
 */
class CommentController extends Controller
{
    /**
     * @Route("/{slug}/add", name="comment_add")
     * @Method({"POST"})
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
     * @Route("/last/{count}", defaults={"count" = 10} ,requirements={"count" = "\d+"} , name="comment_last")
     * @Method({"GET"})
     * @Template()
     */
    public function lastAction($count)
    {
        $comments = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Comment')->findBy([], ['id' => 'DESC'], $count);

        return array(
            "comments" => $comments,
        );
    }
}
