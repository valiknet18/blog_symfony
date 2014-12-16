<?php
namespace Valiknet\Blog\PostsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method as Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use Valiknet\Blog\PostsBundle\Entity\Tag;
use Valiknet\Blog\PostsBundle\Form\Type\AddTagType;

/**
 * @Route("/tag")
 */
class TagController extends Controller
{
   /**
     * @Route("/last", name="tag_last_page")
     * @Method({"GET"})
     * @Template()
     */
    public function lastAction()
    {
        $tags = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Tag')->getLastTags(15);

        return array(
            "tags" => $tags,
        );
    }

    /**
     * @Route("/{slug}", name="tag_page")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction($slug)
    {
        $em = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Tag');
        $tag = $em->findOneByHashSlug($slug);

        return array(
            "tag" => $tag,
        );
    }

    /**
     * @Route("/topTags")
     * @Method({"GET"})
     * @Template()
     */
    public function topTagsAction()
    {
        $tags = $this->getDoctrine()->getManager()->getRepository('ValiknetBlogPostsBundle:Tag')->findTopTags();

        return [
            "tags" => $tags
        ];
    }
}
