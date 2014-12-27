<?php

namespace Valiknet\Blog\PostsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    /**
     * @param $url
     * @param $status
     *
     * @dataProvider provider
     */
    public function testIndex($url, $status)
    {
        $client = static::createClient();

        $client->request('GET', $url);

        $this->assertEquals($status, $client->getResponse()->getStatusCode());
    }

    public function provider()
    {
        return [
            ['/fr', 404],
            ['/ua', 200],
            ['/uk', 404],
            ['/ru', 200],
            ['/en', 200],
            ['/', 200],
            ['/br', 404]
        ];
    }

    /**
     * @dataProvider provider2
     */
    public function testLanguage($lang, $someText)
    {
        $client = static::createClient();

        $crawler = $client->request('GET', $lang);

        $this->assertTrue($crawler->filter('html:contains(' . $someText . ')')->count() > 0);
    }

    public function provider2()
    {
        return [
            ['/ua', 'Доступні мови'],
            ['/ru', 'Список популярных постов'],
            ['/en', 'Create post'],
        ];
    }
}
