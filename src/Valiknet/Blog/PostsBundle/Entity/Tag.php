<?php
namespace Valiknet\Blog\PostsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */
class Tag {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @@RM\Column(type="varchar", length="100")
     */
    protected $hash_tag;

    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="tag")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    protected $post;

    /**
     * Set post
     *
     * @param \Valiknet\Blog\PostsBundle\Entity\Post $post
     * @return Tag
     */
    public function setPost(\Valiknet\Blog\PostsBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \Valiknet\Blog\PostsBundle\Entity\Post 
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
