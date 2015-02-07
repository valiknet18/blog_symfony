<?php
namespace Valiknet\BlogBundle\Tests\Services;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentHandlerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $container = $client->getContainer();

        $post = $container->get('doctrine')
            ->getRepository('ValiknetBlogBundle:Post')
            ->findOneBySlugPost('lorem-ipsum-1521');

        $result = $container->get('valiknet.blogbundle.services.comment_handler')->handleAddComment($post);

        $this->assertInstanceOf('array', $result);
    }
}
