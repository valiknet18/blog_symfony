<?php
namespace Valiknet\Blog\PostsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="comment")
 */
class Comment {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $author;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $text;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $create_at;

    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comment")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    protected $post;

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
     * Set author
     *
     * @param string $author
     * @return Comment
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Comment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set create_at
     *
     * @param \DateTime $createAt
     * @return Comment
     */
    public function setCreateAt($createAt)
    {
        $this->create_at = $createAt;

        return $this;
    }

    /**
     * Get create_at
     *
     * @return \DateTime 
     */
    public function getCreateAt()
    {
        return $this->create_at;
    }

    /**
     * Set post
     *
     * @param \Valiknet\Blog\PostsBundle\Entity\Post $post
     * @return Comment
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
}
