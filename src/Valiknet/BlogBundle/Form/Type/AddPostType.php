<?php
namespace Valiknet\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Valiknet\BlogBundle\Document\Post;
use Valiknet\BlogBundle\Document\Tag;
use Valiknet\BlogBundle\Form\DataTransformer\StringToArrayTransformer;

class AddPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new StringToArrayTransformer();

        $builder
            ->add('title')
            ->add('text', 'textarea', [
                'attr' => [
                    'class' => 'tinymce',
                    'data-theme' => 'bbcode' // Skip it if you want to use default theme
                ]
            ])
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
            'data_class' => 'Valiknet\BlogBundle\Document\Post',
        ));
    }

    public function getName()
    {
        return 'addPost';
    }
}
