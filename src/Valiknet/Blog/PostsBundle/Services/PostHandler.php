<?php
namespace Valiknet\Blog\PostsBundle\Services;

use Valiknet\Blog\PostsBundle\Entity\Post;

class PostHandler
{
    public function removeTags(Post $post)
    {
        foreach ($post->getTag() as $key => $value) {
            $post->removeTag($value);
            $value->removePost($post);
        }
    }
}
