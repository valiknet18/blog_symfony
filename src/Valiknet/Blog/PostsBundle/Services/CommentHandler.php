<?php
/**
 * Created by PhpStorm.
 * User: valik-pc
 * Date: 11.12.14
 * Time: 17:40
 */

namespace Valiknet\Blog\PostsBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommentHandler
{
    private $request;
    private $doctrine;

    public function __construct(RequestStack $request_stack, EntityManager $doctrine)
    {
        $this->request = $request_stack->getCurrentRequest();
        $this->doctrine = $doctrine;
    }

    public function handleAddComment($slug)
    {
        $post = $this->doctrine->getRepository('ValiknetBlogPostsBundle:Post')->findBySlugPost($slug);

        if (!$post) {
            throw new NotFoundHttpException("Page not found");
        }

        $comments = array();

        for ($i = 0; $i < count($post[0]->getComment()); $i++) {
            $comments[$i]["author"] = $post[0]->getComment()[$i]->getAuthor();
            $comments[$i]["text"] = substr($post[0]->getComment()[$i]->getText(), 0, 400);
            $comments[$i]["createdAt"] = $post[0]->getComment()[$i]->getCreatedAt()->format("d.m.Y H:i:s");
        }

        return $comments;
    }
}
