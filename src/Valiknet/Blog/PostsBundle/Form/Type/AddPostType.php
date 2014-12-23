<?php
namespace Valiknet\Blog\PostsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Valiknet\Blog\PostsBundle\Entity\Post;
use Valiknet\Blog\PostsBundle\Entity\Tag;
use Valiknet\Blog\PostsBundle\Form\DataTransformer\StringToArrayTransformer;

class AddPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new StringToArrayTransformer();

        $builder
            ->add('title')
            ->add('text')
            ->add('author')
            ->add(
                $builder->create('tag', 'text', [
                        "mapped" => false
                    ]
                )
                    ->addModelTransformer($transformer)
            );
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
