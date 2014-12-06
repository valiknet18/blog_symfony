<?php
namespace Valiknet\Blog\PostsBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Valiknet\Blog\PostsBundle\Repository\TagRepository")
 * @ORM\Table(name="tag")
 */
class Tag
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $hashTag;

    /**
     * @Gedmo\Slug(fields={"hashTag"})
     * @ORM\Column(type="string", length=12)
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
     * Set hashTag
     *
     * @param  string $hashTag
     * @return Tag
     */
    public function setHashTag($hashTag)
    {
        $this->hashTag = $hashTag;

        return $this;
    }

    /**
     * Get hashTag
     *
     * @return string
     */
    public function getHashTag()
    {
        return $this->hashTag;
    }

    /**
     * Set hashSlug
     *
g     * @param string $hashSlug
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
     * @param  \Valiknet\Blog\PostsBundle\Entity\Post $post
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

    public function __toString()
    {
        return $this->hashTag;
    }
}
