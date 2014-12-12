<?php
namespace Valiknet\Blog\PostsBundle\Tests\Services;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentHandlerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $container = $client->getContainer();

        $result = $container->get('valiknet.blog.postsbundle.services.comment_handler')->handleAddComment('nope');

        $this->assertInstanceOf('NotFoundHttpException', $result);

        $result = $container->get('valiknet.blog.postsbundle.services.comment_handler')->handleAddComment('lorem-ipsum-1521');

        $this->assertInstanceOf('array', $result);
    }
}
 