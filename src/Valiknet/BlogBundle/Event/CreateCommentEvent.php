<?php

namespace Valiknet\BlogBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Valiknet\BlogBundle\Document\Post;
use Valiknet\UserBundle\Document\User;

class CreateCommentEvent extends Event
{
    const NAME = 'createCommentEvent';

    protected $authorPost;
    protected $authorComment;
    protected $post;

    public function __construct(User $authorPost, User $authorComment, Post $post)
    {
        $this->authorPost = $authorPost;
        $this->authorComment = $authorComment;
        $this->post = $post;
    }

    public function getAuthorPost()
    {
        return $this->authorPost;
    }

    public function getAuthorComment()
    {
        return $this->authorComment;
    }

    public function getPost()
    {
        return $this->post;
    }
}