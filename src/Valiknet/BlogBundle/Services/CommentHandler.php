<?php
/**
 * Created by PhpStorm.
 * User: valik-pc
 * Date: 11.12.14
 * Time: 17:40
 */

namespace Valiknet\BlogBundle\Services;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Valiknet\BlogBundle\Document\Post;

class CommentHandler
{
    private $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function handleAddComment(Post $post)
    {
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
