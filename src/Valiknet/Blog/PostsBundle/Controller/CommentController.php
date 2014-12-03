<?php
namespace Valiknet\Blog\PostsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method as Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use Valiknet\Blog\PostsBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/comment")
 */
class CommentController extends Controller
{
    /**
     * @Route("/{id}/add", name="comment_add")
     * @Method({"POST"})
     */
    public function createCommentAction($id, Request $request)
    {
        $comment = new Comment();
        $comment->setAuthor($request->request->get('author'));
        $comment->setText($request->request->get('text'));
        $comment->setPost($this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Post')->find($id));

        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();

        $post = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Post')->find($id);

        $comments = array();

        for($i = 0; $i < count($post->getComment()); $i++) {
            $comments[$i]["author"] = $post->getComment()[$i]->getAuthor();
            $comments[$i]["text"] = $post->getComment()[$i]->getText();
            $comments[$i]["createdAt"] = $post->getComment()[$i]->getCreatedAt()->format("d.m.Y H:i:s");
        }

        return new Response(
            json_encode(
                array(
                    "code" => 200,
                    "data" => $comments
                )
            )
        );
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
            "comments" => $comments
        );
    }
} 