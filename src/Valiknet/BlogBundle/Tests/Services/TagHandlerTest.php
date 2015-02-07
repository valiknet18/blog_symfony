<?php
namespace Valiknet\BlogBundle\Tests\Services;

use Symfony\Bundle\FrameworkBundle\Tests\Functional\WebTestCase;

class TagHandlerTest extends WebTestCase
{
    private function providers()
    {
        return [
            [
                'Laravel, Symfony, YII',
                [
                    "Laravel",
                    "Symfony",
                    "Yii"
                ],
            ]
        ];
    }
}
