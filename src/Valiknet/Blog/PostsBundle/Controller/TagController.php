<?php
namespace Valiknet\Blog\PostsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method as Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use Valiknet\Blog\PostsBundle\Entity\Tag;

/**
 * @Route("/tag")
 */
class TagController extends Controller{

    /**
     * @Route("/view/{slug}", name="tag_page")
     * @Method({"GET"})
     * @Template("ValiknetBlogPostsBundle:Tag:index.html.twig")
     */
    public function getTagPageAction($slug)
    {
        $em = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Tag');
        $tag = $em->findOneByHashSlug($slug);

        return array(
            "tag" => $tag
        );
    }

    /**
     * @Route("/add", name="tag_add_page")
     * @Method({"POST", "GET"})
     * @Template("ValiknetBlogPostsBundle:Tag:add.html.twig")
     */
    public function getAddPageAction(Request $request)
    {
        if($request->isMethod('POST')){
            $tag = new Tag();
            $tag->setHashTag($request->request->get('tag_name'));

            $em = $this->getDoctrine()->getManager();

            $em->persist($tag);
            $em->flush();

            return $this->redirect($this->get('router')->generate('blog_home'));
        }

        return array(

        );
    }

    /**
     * @Route("/last", name="tag_last_page")
     * @Method({"GET"})
     * @Template("ValiknetBlogPostsBundle:Tag:last.html.twig")
     */
    public function getLastTags()
    {
        $tags = $this->getDoctrine()->getRepository('ValiknetBlogPostsBundle:Tag')
                                    ->createQueryBuilder('t')
                                    ->orderBy('t.id', 'DESC')
                                    ->setMaxResults(15)
                                    ->getQuery()
                                    ->getResult();
        return array(
            "tags" => $tags
        );
    }
} 