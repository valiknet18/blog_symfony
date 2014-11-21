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
        $post->setTitle('Перший пост');
        $post->setText('Lorem Ipsum - це текст-"риба", що використовується в друкарстві та дизайні. Lorem Ipsum є, фактично, стандартною "рибою" аж з XVI сторіччя, коли невідомий друкар взяв шрифтову гранку та склав на ній підбірку зразків шрифтів. "Риба" не тільки успішно пережила п\'ять століть, але й прижилася в електронному верстуванні, залишаючись по суті незмінною. Вона популяризувалась в 60-их роках минулого сторіччя завдяки виданню зразків шрифтів Letraset, які містили уривки з Lorem Ipsum, і вдруге - нещодавно завдяки програмам комп\'ютерного верстування на кшталт Aldus Pagemaker, які використовували різні версії Lorem Ipsum.');
        $post->setAuthor('Гриневич В. О');
        $post->setCreatedAt(new \DateTime());

        $tag1 = new Tag();
        $tag1->setHashTag("programming");
        $tag1->addPost($post);


        $tag2 = new Tag();
        $tag2->setHashTag("firstPost");
        $tag2->addPost($post);

        $post->addTag($tag1);
        $post->addTag($tag2);


        $manager->persist($post);
        $manager->persist($tag1);
        $manager->persist($tag2);


        $post = new Post();
        $post->setTitle('Другий пост');
        $post->setText('Lorem Ipsum - це текст-"риба", що використовується в друкарстві та дизайні. Lorem Ipsum є, фактично, стандартною "рибою" аж з XVI сторіччя, коли невідомий друкар взяв шрифтову гранку та склав на ній підбірку зразків шрифтів. "Риба" не тільки успішно пережила п\'ять століть, але й прижилася в електронному верстуванні, залишаючись по суті незмінною. Вона популяризувалась в 60-их роках минулого сторіччя завдяки виданню зразків шрифтів Letraset, які містили уривки з Lorem Ipsum, і вдруге - нещодавно завдяки програмам комп\'ютерного верстування на кшталт Aldus Pagemaker, які використовували різні версії Lorem Ipsum.');
        $post->setAuthor('Гриневич В. О');
        $post->setCreatedAt(new \DateTime());


        $tag2 = new Tag();
        $tag2->setHashTag("socialnetworks");
        $tag2->addPost($post);

        $tag1->addPost($post);
        $post->addTag($tag1);
        $post->addTag($tag2);

        $manager->persist($post);
        $manager->persist($tag1);
        $manager->persist($tag2);

        $manager->flush();
    }
} 