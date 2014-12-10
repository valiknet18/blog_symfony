<?php
namespace Valiknet\Blog\PostsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Valiknet\Blog\PostsBundle\Entity\Post;
use Valiknet\Blog\PostsBundle\Entity\Tag;

class AddPostType extends AbstractType
{
    public $tags;

    public function __construct(array $tags)
    {
        $this->tags = $tags;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $tag = $this->tags;

        $builder
            ->add('title')
            ->add('text')
            ->add('author')
            ->add('tag', 'entity', [
                'class' => 'ValiknetBlogPostsBundle:Tag',
                'choices' => new GetTagType($tag),
                'multiple' => true
            ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Valiknet\Blog\PostsBundle\Entity\Post',
        ));
    }

    public function getName()
    {
        return 'addPost';
    }
}
