<?php
namespace Valiknet\BlogBundle\DataFixtures;

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
