<?php
namespace Valiknet\Blog\PostsBundle\Tests\Services;

use Symfony\Bundle\FrameworkBundle\Tests\Functional\WebTestCase;

class TagHandlerTest extends WebTestCase
{
    /**
     * @dataProvider providers
     */
    public function testTag($string, $resultArray)
    {
        $client = static::createClient();

        $container = $client->getContainer();

        $result = $container->get('valiknet.blog.postsbundle.services.tag_handler')->convertTags($string);

        $this->assertEquals($resultArray, $result);
    }

    private function providers()
    {
        return [
            [
                'Laravel, Symfony, YII',
                [
                    "Laravel",
                    "Symfony",
                    "Yii"
                ]
            ]
        ];
    }
}
