<?php
namespace Valiknet\Blog\PostsBundle\Form\DataTransformer;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;

class StringToArrayTransformer implements DataTransformerInterface
{
    private $em;
    private $data;

    public function __construct(EntityManager $em = null, $data = null)
    {
        if ($em !== null) {
            $this->em = $em;
            $this->data = $data;
        }
    }

    public function transform($array)
    {
        if ($array === null) {
            return "";
        }

        $post = $this->em->getRepository('ValiknetBlogPostsBundle:Post')
                ->findOneById($this->data->getId());

        $tags = [];

        foreach ($post->getTag() as $tag) {
            $tags[] = $tag->getHashTag();
        }

        return implode(", ", $tags);
    }

    public function reverseTransform($string)
    {
        if ($string === null || is_array($string)) {
            return (is_array($string)) ? $string : null;
        }

        $tags = explode(',', $string);

        foreach ($tags as &$tag) {
            $tag = ucfirst(strtolower(trim($tag)));
        }

        return $tags;
    }
}
