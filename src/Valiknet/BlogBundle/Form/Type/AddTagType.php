<?php
namespace Valiknet\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Valiknet\BlogBundle\Document\Tag;

class AddTagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('hashTag', 'text', ['label' => 'Назва тегу']);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Valiknet\BlogBundle\Document\Tag',
        ));
    }

    public function getName()
    {
        return 'addTag';
    }
}
