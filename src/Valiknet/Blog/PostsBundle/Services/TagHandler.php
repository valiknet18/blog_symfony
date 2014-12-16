<?php
namespace Valiknet\Blog\PostsBundle\Services;

class TagHandler
{
    public function convertTags($tags)
    {
        $tags = explode(',', $tags);

        foreach ($tags as &$tag) {
            $tag = $this->covertTag($tag);
        }

        return $tags;
    }

    private function covertTag($tag)
    {
        return ucfirst(strtolower(trim($tag)));
    }
} 