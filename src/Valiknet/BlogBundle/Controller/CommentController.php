<?php
namespace Valiknet\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use Valiknet\BlogBundle\Document\Comment;
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
            $comment->setPost($this->getDoctrine()->getManager()->getRepository('ValiknetBlogBundle:Post')->findOneBySlugPost($slug));

            $dm->persist($comment);
            $dm->flush();

            $post = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('ValiknetBlogBundle:Post')
                    ->findBySlugPost($slug);

            $comments = $this->get('valiknet.blogbundle.services.comment_handler')->handleAddComment($post);

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
