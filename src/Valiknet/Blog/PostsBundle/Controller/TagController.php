<?php
namespace Valiknet\Blog\PostsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use Valiknet\Blog\PostsBundle\Entity\Tag;
use Valiknet\Blog\PostsBundle\Form\Type\AddTagType;

class TagController extends Controller
{
    /**
     * @Template()
     * @return array
     */
    public function lastAction()
    {
        $tags = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Tag')->getLastTags(15);

        return array(
            "tags" => $tags,
        );
    }

    /**
     * @Template()
     * @param $slug
     * @return array
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
     * @Template()
     * @return array
     */
    public function topTagsAction()
    {
        $tags = $this->getDoctrine()->getManager()->getRepository('ValiknetBlogPostsBundle:Tag')->findTopTags();

        return [
            "tags" => $tags
        ];
    }
}
