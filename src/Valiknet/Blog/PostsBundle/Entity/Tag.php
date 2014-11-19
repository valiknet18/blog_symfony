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

    /**
     * Set tag
     *
     * @param \string $tag
     * @return Tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return \varchar 
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Tag
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
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
     * Set slug_hash
     *
     * @param string $slugHash
     * @return Tag
     */
    public function setSlugHash($slugHash)
    {
        $this->slug_hash = $slugHash;

        return $this;
    }

    /**
     * Get slug_hash
     *
     * @return string 
     */
    public function getSlugHash()
    {
        return $this->slug_hash;
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
}
