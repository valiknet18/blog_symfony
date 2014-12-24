<?php
namespace Valiknet\Blog\PostsBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository
{
    public function findTopTags()
    {
        $tags = $this->getEntityManager()->getRepository('ValiknetBlogPostsBundle:Tag')
            ->createQueryBuilder('t')
            ->groupBy('t.hashTag')
            ->getQuery()
            ->getResult();

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
        $tags = $this->getEntityManager()->getRepository('ValiknetBlogPostsBundle:Tag')
            ->createQueryBuilder('t')
            ->orderBy('t.id', 'DESC')
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();

        return $tags;
    }

    public function getHastTags()
    {
        return $this->getEntityManager()
            ->getRepository('ValiknetBlogPostsBundle:Tag')
            ->createQueryBuilder('t')
            ->select('t.hashTag')
            ->getQuery()
            ->getResult();
    }
}
