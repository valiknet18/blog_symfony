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

        $user = $this->getUser();

        return array(
            "tags" => $tags,
            "user" => $user,
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

        $user = $this->getUser();

        return array(
            "tag" => $tag,
            "user" => $user,
        );
    }

    /**
     * @Template()
     * @return array
     */
    public function topTagsAction()
    {
        $tags = $this->getMongoDbManager()->getRepository('ValiknetBlogBundle:Tag')->findTopTags();

        $user = $this->getUser();

        return [
            "tags" => $tags,
            "user" => $user
        ];
    }
}
