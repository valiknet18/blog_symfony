<?php
namespace Valiknet\Blog\PostsBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Valiknet\Blog\PostsBundle\Entity\Post;
use Valiknet\Blog\PostsBundle\Entity\Tag;

class LoadPostData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $post = new Post();
        $post->setName('Перший пост');
        $post->setText('Lorem Ipsum - це текст-"риба", що використовується в друкарстві та дизайні. Lorem Ipsum є, фактично, стандартною "рибою" аж з XVI сторіччя, коли невідомий друкар взяв шрифтову гранку та склав на ній підбірку зразків шрифтів. "Риба" не тільки успішно пережила п\'ять століть, але й прижилася в електронному верстуванні, залишаючись по суті незмінною. Вона популяризувалась в 60-их роках минулого сторіччя завдяки виданню зразків шрифтів Letraset, які містили уривки з Lorem Ipsum, і вдруге - нещодавно завдяки програмам комп\'ютерного верстування на кшталт Aldus Pagemaker, які використовували різні версії Lorem Ipsum.');
        $post->setAuthor('Гриневич В. О');
        $post->setCreateAt(new \DateTime());

        $manager->persist($post);

        $tag1 = new Tag();
        $tag1->setTag("programming");
        $tag1->setPost($post);

        $tag2 = new Tag();
        $tag2->setTag("firstPost");
        $tag2->setPost($post);

        $manager->persist($tag1);
        $manager->persist($tag2);
        $manager->flush();
    }
} 