<?php
namespace Valiknet\Blog\PostsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Valiknet\Blog\PostsBundle\Entity\Tag;

class EditPostType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $tags = $options['data'];

        $obj = new GetTagType($tags);

        $builder
            ->add('title')
            ->add('text')
            ->add('author');

        $builder
            ->add('tag', 'collection', array(
                'type' =>  $obj,
                'mapped' => true,
                'allow_add' => false,
                'by_reference' => false,
            ));
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