<?php
namespace Valiknet\Blog\PostsBundle\Tests\Services;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentHandlerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $container = $client->getContainer();

        $post = $container->get('doctrine')
            ->getRepository('ValiknetBlogPostsBundle:Post')
            ->findBySlugPost('nope');

        $result = $container->get('valiknet.blog.postsbundle.services.comment_handler')
            ->handleAddComment($post);

        $this->assertInstanceOf('NotFoundHttpException', $result);

        $post = $container->get('doctrine')
            ->getRepository('ValiknetBlogPostsBundle:Post')
            ->findBySlugPost('lorem-ipsum-1521');

        $result = $container->get('valiknet.blog.postsbundle.services.comment_handler')->handleAddComment($post);

        $this->assertInstanceOf('array', $result);
    }
}
