<?php
namespace Valiknet\BlogBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Tag
 * @package Valiknet\Blog\PostsBundle\Document
 *
 * @ODM\Document(repositoryClass="Valiknet\BlogBundle\Repository\TagRepository")
 */
class Tag
{
    /**
     * @ODM\Id
     */
    protected $id;

    /**
     * @ODM\Field(type="string")
     */
    protected $hashTag;

    /**
     * @Gedmo\Slug(fields={"hashTag"})
     * @ODM\Field(type="string")
     */
    protected $hashSlug;

    /**
     * @ODM\ReferenceMany(targetDocument="Post")
     */
    protected $post;
    public function __construct()
    {
        $this->post = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set hashTag
     *
     * @param  string $hashTag
     * @return self
     */
    public function setHashTag($hashTag)
    {
        $this->hashTag = $hashTag;

        return $this;
    }

    /**
     * Get hashTag
     *
     * @return string $hashTag
     */
    public function getHashTag()
    {
        return $this->hashTag;
    }

    /**
     * Set hashSlug
     *
     * @param  string $hashSlug
     * @return self
     */
    public function setHashSlug($hashSlug)
    {
        $this->hashSlug = $hashSlug;

        return $this;
    }

    /**
     * Get hashSlug
     *
     * @return string $hashSlug
     */
    public function getHashSlug()
    {
        return $this->hashSlug;
    }

    /**
     * Add post
     *
     * @param Valiknet\BlogBundle\Document\Post $post
     */
    public function addPost(\Valiknet\BlogBundle\Document\Post $post)
    {
        $this->post[] = $post;
    }

    /**
     * Remove post
     *
     * @param Valiknet\BlogBundle\Document\Post $post
     */
    public function removePost(\Valiknet\BlogBundle\Document\Post $post)
    {
        $this->post->removeElement($post);
    }

    /**
     * Get post
     *
     * @return Doctrine\Common\Collections\Collection $post
     */
    public function getPost()
    {
        return $this->post;
    }
}
