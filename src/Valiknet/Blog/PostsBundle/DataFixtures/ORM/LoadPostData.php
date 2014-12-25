<?php
namespace Valiknet\Blog\PostsBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Valiknet\Blog\PostsBundle\Entity\Post;
use Valiknet\Blog\PostsBundle\Entity\Tag;

class LoadPostData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {

    }
}
