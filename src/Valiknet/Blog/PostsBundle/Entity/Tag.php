<?php
namespace Valiknet\Blog\PostsBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
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
     * @ORM\Column(type="string", length=100, name="hashTag")
     */
    protected $hash_tag;

    /**
     * @Gedmo\Slug(fields={"hash_tag"})
     * @ORM\Column(type="string", length=128, name="hashSlug")
     */
    protected $hashSlug;

    /**
     * @ORM\ManyToMany(targetEntity="Post", inversedBy="tag")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    protected $post;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->post = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set hash_tag
     *
     * @param string $hashTag
     * @return Tag
     */
    public function setHashTag($hashTag)
    {
        $this->hash_tag = $hashTag;

        return $this;
    }

    /**
     * Get hash_tag
     *
     * @return string 
     */
    public function getHashTag()
    {
        return $this->hash_tag;
    }

    /**
     * Set hashSlug
     *
     * @param string $hashSlug
     * @return Tag
     */
    public function setHashSlug($hashSlug)
    {
        $this->hashSlug = $hashSlug;

        return $this;
    }

    /**
     * Get hashSlug
     *
     * @return string 
     */
    public function getHashSlug()
    {
        return $this->hashSlug;
    }

    /**
     * Add post
     *
     * @param \Valiknet\Blog\PostsBundle\Entity\Post $post
     * @return Tag
     */
    public function addPost(\Valiknet\Blog\PostsBundle\Entity\Post $post)
    {
        $this->post[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \Valiknet\Blog\PostsBundle\Entity\Post $post
     */
    public function removePost(\Valiknet\Blog\PostsBundle\Entity\Post $post)
    {
        $this->post->removeElement($post);
    }

    /**
     * Get post
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPost()
    {
        return $this->post;
    }
}
