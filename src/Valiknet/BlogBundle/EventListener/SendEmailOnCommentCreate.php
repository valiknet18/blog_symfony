<?php

namespace Valiknet\BlogBundle\EventListener;

use Symfony\Bundle\TwigBundle\Debug\TimedTwigEngine;
use Valiknet\BlogBundle\Document\Post;
use Valiknet\BlogBundle\Event\CreateCommentEvent;
use Valiknet\UserBundle\Document\User;

class SendEmailOnCommentCreate
{
    protected $mailer;
    protected $template;

    public function __contruct(\Swift_Mailer $mailer, TimedTwigEngine $twig)
    {
        $this->mailer = $mailer;
        $this->template = $twig;
    }

    public function onCommentCreate(CreateCommentEvent $event)
    {
        return $this->renderEmail($event->getAuthorPost(), $event->getAuthorComment(), $event->getPost());
    }

    public function renderEmail(User $authorPost, User $authorComment, Post $post)
    {
        $message = $this->mailer
                        ->createMessage()
                        ->setSubject('Новий комментар до вашої статі '.$post->getTitle())
                        ->setFrom('valik.v1per@gmail.com')
                        ->setTo($authorPost->getEmail())
                        ->setBody(
                            $this->template
                                 ->render(
                                     'ValiknetBlogBundle:Email:createComment.html.twig',
                                     [
                                         "authorComment" => $authorComment,
                                         "post" => $post
                                     ]
                                 ),
                            'text/html'
                        );

        return $this->mailer->send($message);
    }
}