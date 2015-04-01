<?php
namespace Valiknet\BlogBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Comment
 * @package Valiknet\Blog\PostsBundle\Document
 *
 * @ODM\Document
 */
class Comment
{
    /**
     * @ODM\Id
     */
    protected $id;

    /**
     * @ODM\ReferenceOne(targetDocument="Valiknet\UserBundle\Document\User")
     */
    protected $author;

    /**
     * @ODM\Field(type="string")
     */
    protected $text;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ODM\Field(type="date")
     */
    protected $createdAt;

    /**
     * @ODM\ReferenceOne(targetDocument="Post")
     */
    protected $post;

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
     * Set text
     *
     * @param  string $text
     * @return self
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string $text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set createdAt
     *
     * @param  date $createdAt
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return date $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set post
     *
     * @param  Valiknet\BlogBundle\Document\Post $post
     * @return self
     */
    public function setPost(\Valiknet\BlogBundle\Document\Post $post)
    {
        $this->post = $post;
        $post->addComment($this);

        return $this;
    }

    /**
     * Get post
     *
     * @return Valiknet\BlogBundle\Document\Post $post
     */
    public function getPost()
    {
        return $this->post;
    }
    public function __construct()
    {
        $this->author = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set author
     *
     * @param Valiknet\UserBundle\Document\User $author
     * @return self
     */
    public function setAuthor(\Valiknet\UserBundle\Document\User $author)
    {
        $this->author = $author;
        $author->addComment($this);

        return $this;
    }

    /**
     * Get author
     *
     * @return Valiknet\UserBundle\Document\User $author
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
