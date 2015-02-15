<?php
namespace Valiknet\BlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use Valiknet\BlogBundle\Document\Tag;

class TagController extends BlogAbstractController
{
    /**
     * @Template()
     *
     * @return array
     */
    public function lastAction()
    {
        $tags = $this->getMongoDbManager()->getRepository('ValiknetBlogBundle:Tag')->getLastTags(15);

        return array(
            "tags" => $tags,
        );
    }

    /**
     * @Template()
     *
     * @param $slug
     * @return array
     */
    public function indexAction($slug)
    {
        $tag = $this->getMongoDbManager()->getRepository('ValiknetBlogBundle:Tag')->findOneByHashSlug($slug);

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
        $tags = $this->getMongoDbManager()->getRepository('ValiknetBlogBundle:Tag')->findTopTags();

        return [
            "tags" => $tags,
        ];
    }
}
