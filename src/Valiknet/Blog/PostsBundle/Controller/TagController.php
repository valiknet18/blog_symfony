<?php
namespace Valiknet\Blog\PostsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method as Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;

/**
 * @Route("/tag")
 */
class TagController extends Controller{

    /**
     * @Route("/{slug}", name="tag_page")
     * @Method({"GET"})
     * @Template("ValiknetBlogPostsBundle:Tag:index.html.twig")
     */
    public function getTagPage($slug)
    {
        $em = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Tag');
        $tag = $em->findByHashSlug($slug);

        return array(
            "tag" => $tag
        );
    }
} 