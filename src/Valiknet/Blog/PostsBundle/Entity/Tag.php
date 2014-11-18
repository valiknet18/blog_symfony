<?php
namespace Valiknet\Blog\PostsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */
class Tag {

    /**
     * @@RM\Column(type="varchar", length="100")
     */
    protected $hash_tag;

    /**
     * @ORM\ManyToOne(TargetEntity="Post", inversedBy="tag")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    protected $post;
} 