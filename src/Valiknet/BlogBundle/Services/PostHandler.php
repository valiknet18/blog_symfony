<?php
namespace Valiknet\BlogBundle\Services;

use Doctrine\ORM\EntityManager;
use Valiknet\BlogBundle\Document\Post;
use Valiknet\BlogBundle\Document\Tag;

class PostHandler
{
    public function removeTags(Post $post)
    {
        foreach ($post->getTag() as $key => $value) {
            $post->removeTag($value);
            $value->removePost($post);
        }
    }

    public function addTags(Post $post, $tags, $dm)
    {
        foreach ($tags as $tag) {
            $tagRequest = $dm->getRepository('ValiknetBlogBundle:Tag')
                ->findByHashTag($tag);

            if (!$tagRequest) {
                $newTag = new Tag();
                $newTag->setHashTag($tag);

                $post->addTag($newTag);

                $dm->persist($newTag);
            } else {
                $post->addTag($tagRequest[0]);
            }
        }
    }
}
