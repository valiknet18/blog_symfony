<?php
namespace Valiknet\Blog\PostsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method as Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use Valiknet\Blog\PostsBundle\Entity\Tag;
use Valiknet\Blog\PostsBundle\Form\Type\GetTagType;

/**
 * @Route("/tag")
 */
class TagController extends Controller
{
    /**
     * @Route("/add", name="tag_add_page")
     * @Method({"POST", "GET"})
     * @Template()
     */
    public function addAction(Request $request)
    {
        $tag = new Tag();

        $em = $this->getDoctrine()->getManager();

        $tags = $em->getRepository('ValiknetBlogPostsBundle:Tag')->getHastTags();

        $form = $this->createForm(new GetTagType($tags), $tag);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($tag);
            $em->flush();

            return $this->redirect($this->get('router')->generate('blog_home'));
        }

        return [
            "form" => $form->createView()
        ];
    }

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
