<?php
namespace Valiknet\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use Valiknet\BlogBundle\BlogAbstractController;

class TagController extends BlogAbstractController
{
    /**
     * @Template()
     * @return array
     */
    public function lastAction()
    {
        $tags = $this->getMongoDbManager()->getRepository('ValiknetBlogPostsBundle:Tag')->getLastTags(15);

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
        $dm = $this->getMongoDbManager()->getRepository('ValiknetBlogPostsBundle:Tag');
        $tag = $dm->findOneByHashSlug($slug);

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
        $tags = $this->getMongoDbManager()->getRepository('ValiknetBlogPostsBundle:Tag')->findTopTags();

        return [
            "tags" => $tags
        ];
    }
}
