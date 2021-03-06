<?php
namespace Valiknet\BlogBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Post
 * @package Valiknet\Blog\PostsBundle\Document
 *
 * @ODM\Document(repositoryClass="Valiknet\BlogBundle\Repository\PostRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ODM\HasLifecycleCallbacks()
 */
class Post
{
    /**
     * @ODM\Id
     */
    protected $id;

    /**
     * @ODM\Field(type="string")
     */
    protected $title;

    /**
     * @ODM\Field(type="string")
     */
    protected $text;

    /**
     * @ODM\ReferenceOne(targetDocument="Valiknet\UserBundle\Document\User")
     */
    protected $author;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ODM\Field(type="date")
     */
    protected $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ODM\Field(type="date")
     */
    protected $updatedAt;

    /**
     * @ODM\Field(type="date")
     */
    protected $deletedAt;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ODM\Field(type="string")
     */
    protected $slugPost;

    /**
     * @ODM\ReferenceMany(targetDocument="Comment", orphanRemoval=true)
     */
    protected $comment;

    /**
     * @ODM\ReferenceMany(targetDocument="Tag")
     */
    protected $tag;

    public function __construct()
    {
        $this->comment = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tag = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param  string $title
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
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
     * Set updatedAt
     *
     * @param  date $updatedAt
     * @return self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return date $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set deletedAt
     *
     * @param  date $deletedAt
     * @return self
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return date $deletedAt
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set slugPost
     *
     * @param  string $slugPost
     * @return self
     */
    public function setSlugPost($slugPost)
    {
        $this->slugPost = $slugPost;

        return $this;
    }

    /**
     * Get slugPost
     *
     * @return string $slugPost
     */
    public function getSlugPost()
    {
        return $this->slugPost;
    }

    /**
     * Add comment
     *
     * @param Valiknet\BlogBundle\Document\Comment $comment
     */
    public function addComment(\Valiknet\BlogBundle\Document\Comment $comment)
    {
        $this->comment[] = $comment;
    }

    /**
     * Remove comment
     *
     * @param Valiknet\BlogBundle\Document\Comment $comment
     */
    public function removeComment(\Valiknet\BlogBundle\Document\Comment $comment)
    {
        $this->comment->removeElement($comment);
    }

    /**
     * Get comment
     *
     * @return Doctrine\Common\Collections\Collection $comment
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Add tag
     *
     * @param Tag $tag
     * @return $this
     */
    public function addTag(\Valiknet\BlogBundle\Document\Tag $tag)
    {
        $this->tag[] = $tag;
        $tag->addPost($this);

        return $this;
    }

    /**
     * Remove tag
     *
     * @param Valiknet\BlogBundle\Document\Tag $tag
     */
    public function removeTag(\Valiknet\BlogBundle\Document\Tag $tag)
    {
        $this->tag->removeElement($tag);
    }

    /**
     * Get tag
     *
     * @return Doctrine\Common\Collections\Collection $tag
     */
    public function getTag()
    {
        return $this->tag;
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
        $author->addPost($this);

        return $this;
    }

    /**
     * Get author
     *
     * @return Valiknet\UserBundle\User $author
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
