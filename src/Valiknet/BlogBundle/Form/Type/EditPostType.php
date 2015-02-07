<?php
namespace Valiknet\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Valiknet\BlogBundle\Document\Tag;
use Valiknet\BlogBundle\Form\DataTransformer\StringToArrayTransformer;

class EditPostType extends AbstractType
{
    public $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new StringToArrayTransformer($this->em, $builder->getData());

        $builder
            ->add('title')
            ->add('text')
            ->add('author')
            ->add(
                $builder->create('tag', 'text', [
                    'mapped' => false
                ])
//                ->addModelTransformer($transformer)
                ->addViewTransformer($transformer)
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
        return 'editPost';
    }
}
