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
        $comment = new Comment();

        $form = $this->createForm(new AddCommentType(), $comment);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $comment->setPost($this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Post')->findOneBySlugPost($slug));

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            $post = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Post')->findBy(['slugPost' => $slug]);

            $comments = array();

            for ($i = 0; $i < count($post[0]->getComment()); $i++) {
                $comments[$i]["author"] = $post[0]->getComment()[$i]->getAuthor();
                $comments[$i]["text"] = $post[0]->getComment()[$i]->getText();
                $comments[$i]["createdAt"] = $post[0]->getComment()[$i]->getCreatedAt()->format("d.m.Y H:i:s");
            }

            return new JsonResponse($comments);
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
