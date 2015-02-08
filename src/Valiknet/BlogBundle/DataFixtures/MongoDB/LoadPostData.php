<?php
namespace Valiknet\BlogBundle\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Hautelook\AliceBundle\Alice\DataFixtureLoader;

class LoadPostData extends DataFixtureLoader
{
    public function getFixtures()
    {
        return [
            __DIR__."/fixtures.yml"
        ];
    }
}
