<?php
namespace Valiknet\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogAbstractController extends Controller
{
    public function getMongoDbManager()
    {
        return $this->get('doctrine.odm.mongodb.document_manager');
    }
}
