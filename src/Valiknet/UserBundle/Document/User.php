<?php
namespace Valiknet\UserBundle\Document;

use FOS\UserBundle\Document\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ODM\Document
 */
class User extends BaseUser
{
    /**
     * @ODM\Id()
     */
    protected $id;

    /**
     * @ODM\Field(type="string")
     */
    protected $firstName;

    /**
     * @ODM\Field(type="string")
     */
    protected $lastName;

    /**
     * @ODM\ReferenceMany(targetDocument="Valiknet\BlogBundle\Document\Post")
     */
    protected $posts;

    /**
     * @Gedmo\Slug(fields={"firstName", "lastName"})
     * @ODM\Field(type="string")
     */
    protected $slug;

    /**
     * @ODM\ReferenceMany(targetDocument="Valiknet\BlogBundle\Document\Comment")
     */
    protected $comments;

    public function __construct()
    {
        parent::__construct();
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
     * Add post
     *
     * @param Valiknet\BlogBundle\Document\Post $post
     */
    public function addPost(\Valiknet\BlogBundle\Document\Post $post)
    {
        $this->posts[] = $post;
    }

    /**
     * Remove post
     *
     * @param Valiknet\BlogBundle\Document\Post $post
     */
    public function removePost(\Valiknet\BlogBundle\Document\Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Get posts
     *
     * @return Doctrine\Common\Collections\Collection $posts
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return self
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string $firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return self
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string $lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Add comment
     *
     * @param Valiknet\BlogBundle\Document\Comment $comment
     */
    public function addComment(\Valiknet\BlogBundle\Document\Comment $comment)
    {
        $this->comments[] = $comment;
    }

    /**
     * Remove comment
     *
     * @param Valiknet\BlogBundle\Document\Comment $comment
     */
    public function removeComment(\Valiknet\BlogBundle\Document\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return Doctrine\Common\Collections\Collection $comments
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return self
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * Get slug
     *
     * @return string $slug
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
