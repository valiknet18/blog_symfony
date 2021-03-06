<?php
namespace Valiknet\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use Valiknet\BlogBundle\Document\Comment;
use Valiknet\BlogBundle\Event\CreateCommentEvent;
use Valiknet\BlogBundle\Form\Type\AddCommentType;

class CommentController extends BlogAbstractController
{
    /**
     * @param $slug
     * @param  Request      $request
     * @return JsonResponse
     */
    public function createCommentAction($slug, Request $request)
    {
        $dm = $this->getMongoDbManager();

        $comment = new Comment();

        $form = $this->createForm(new AddCommentType(), $comment);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $post = $dm->getRepository('ValiknetBlogBundle:Post')->findOneBySlugPost($slug);

            $comment->setPost($post);

            $comment->setAuthor($this->getUser());

            $dm->persist($comment);
            $dm->flush();

            $post = $dm->getRepository('ValiknetBlogBundle:Post')
                    ->findOneBySlugPost($slug);

            $comments = $this->get('valiknet.blogbundle.services.comment_handler')->handleAddComment($post);

            //Send email author
            $event = new CreateCommentEvent($post->getAuthor(), $this->getUser(), $post);

            $this->get('event_dispatcher')->dispatch(CreateCommentEvent::NAME, $event);

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
        $comments = $this->getMongoDbManager()->getRepository('ValiknetBlogBundle:Comment')->findBy([], ['id' => 'DESC'], $count);

        return array(
            "comments" => $comments,
        );
    }
}
