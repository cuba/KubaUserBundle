<?php
namespace Kuba\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', 'text');    
        $builder->add('email', 'repeated', array (
            'type'       => 'email',
            'first_options'  => array('label' => 'Email'),
            'second_options' => array('label' => 'Repeat Email'),
            'invalid_message' => "The emails don't match!"
        ));
        $builder->add('password', 'repeated', array (
            'type'       => 'password',
            'first_options'  => array('label' => 'Password'),
            'second_options' => array('label' => 'Repeat Password'),
            'invalid_message' => "The passwords don't match!"
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kuba\UserBundle\Form\Model\Registration',
            'csrf_protection' => true,
            'intention'       => 'iwillnotbuythisrecorditisscratched'
        ));
    }

    public function getName()
    {
        return 'kuba_user_registration';
    }
}