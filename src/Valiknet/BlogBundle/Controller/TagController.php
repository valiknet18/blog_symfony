<?php
namespace Valiknet\BlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     * @param Tag $tag
     * @return array
     *
     * @ParamConverter("Tag", options={"mapping": {"hashSlug": "slug"}})
     */
    public function indexAction(Tag $tag)
    {
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
            "tags" => $tags
        ];
    }
}
