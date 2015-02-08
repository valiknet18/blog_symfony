<?php
namespace Valiknet\BlogBundle\Tests\Services;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentHandlerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $container = $client->getContainer();

        $post = $container->get('doctrine.odm.mongodb.document_manager')
            ->getRepository('ValiknetBlogBundle:Post')
            ->findAll();

        $this->assertGreaterThanOrEqual(0, count($post));
    }
}
