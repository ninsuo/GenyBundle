<?php

namespace Fuz\GenyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * This type returns a collection of key/value pair; as
 * data are returned as an associative array, key must
 * be scalar.
 */
class HashType extends AbstractType
{
    protected $keyType;
    protected $valueType;

    public function __construct($keyType, $valueType)
    {
        $this->keyType   = $keyType;
        $this->valueType = $valueType;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('key', $this->keyType, $options);
        $builder->add('value', $this->valueType, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'form';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'hash';
    }

}
