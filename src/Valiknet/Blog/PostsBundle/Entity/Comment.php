<?php
namespace Valiknet\Blog\PostsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="comment")
 */
class Comment {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GenerateValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length="200")
     */
    protected $author;

    /**
     * @ORM\Column(type="string", length="255")
     */
    protected $text;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $create_at;

    /**
     * @ORM\ManyToOne(TargetEntity="Post", inversedBy="comment")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    protected $post;
} 