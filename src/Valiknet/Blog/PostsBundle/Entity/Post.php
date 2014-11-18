<?php
namespace Valiknet\Blog\PostsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="post")
 */
class Post {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GenerateValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length="150")
     */
    protected $name;

    /**
     * @ORM\Column(type="text")
     */
    protected $text;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $create_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $update_at;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post")
     */
    protected $comment;

    /**
     * @ORM\OneToMany(targetEntity="Tag", mappedBy="post")
     */
    protected $tag;
}