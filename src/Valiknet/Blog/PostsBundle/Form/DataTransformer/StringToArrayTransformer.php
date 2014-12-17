<?php
namespace Valiknet\Blog\PostsBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class StringToArrayTransformer implements DataTransformerInterface
{

    public function transform($string)
    {
    }

    public function reverseTransform($string)
    {
        if (!$string) {
            return array();
        }

        $tags = explode(',', $string);

        foreach ($tags as &$tag) {
            $tag = ucfirst(strtolower(trim($tag)));
        }

        return $tags;
    }
} 