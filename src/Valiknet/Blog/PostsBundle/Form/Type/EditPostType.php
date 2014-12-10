<?php
namespace Valiknet\Blog\PostsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Valiknet\Blog\PostsBundle\Entity\Tag;

class EditPostType extends AbstractType
{
    public $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $selected = array();

        foreach ($options['data']->getTag() as $key => $value) {
            $selected[] = $this->em->getReference('ValiknetBlogPostsBundle:Tag', $value->getId());
        }

        $builder
            ->add('title')
            ->add('text')
            ->add('author')
            ->add('tag', 'entity', [
                'class' => 'ValiknetBlogPostsBundle:Tag',
                'property' => 'hashTag',
                'data' => $selected,
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
