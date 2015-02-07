<?php
namespace Valiknet\BlogBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

class TagRepository extends DocumentRepository
{
    public function findTopTags()
    {
        $tags = $this->getDocumentManager()->getRepository('ValiknetBlogBundle:Tag')
            ->createQueryBuilder('t')
            ->group(array(), array('t.hashTag' => 0))
            ->getQuery()
            ->execute();

        if (count($tags) == 0) {
            return 0;
        }

        usort($tags, function ($a, $b) {
            if (COUNT($a->getPost()) == COUNT($b->getPost())) {
                return 0;
            }

            return (COUNT($a->getPost()) > COUNT($b->getPost())) ? -1 : 1;
        });

        $tags = array_slice($tags, 0, 10);

        return $tags;
    }

    public function getLastTags($count)
    {
        $tags = $this->getDocumentManager()->getRepository('ValiknetBlogBundle:Tag')
            ->createQueryBuilder('t')
            ->sort('t.id', 'desc')
            ->limit($count)
            ->getQuery()
            ->execute();

        return $tags;
    }

    public function getHastTags()
    {
        return $this->getDocumentManager()
            ->getRepository('ValiknetBlogBundle:Tag')
            ->createQueryBuilder('t')
            ->select('t.hashTag')
            ->getQuery()
            ->execute();
    }
}
