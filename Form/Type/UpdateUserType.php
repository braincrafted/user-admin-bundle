<?php
/**
 * This file is part of BcUserAdminBundle.
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserAdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * UpdateUserType
 *
 * @category    FormType
 * @package     BcUserAdminBundle
 * @subpackage  Form
 * @author      Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright   2013 Florian Eckerstorfer
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
class UpdateUserType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'username',
            'text',
            array('label' => 'form.username', 'translation_domain' => 'BcUserAdminBundle')
        );
        $builder->add(
            'email',
            'text',
            array('label' => 'form.email', 'translation_domain' => 'BcUserAdminBundle')
        );
        $builder->add(
            'plainPassword',
            'password',
            array('label' => 'form.password', 'translation_domain' => 'BcUserAdminBundle'));
        $builder->add(
            'enabled',
            'checkbox',
            array('label' => 'form.enabled', 'translation_domain' => 'BcUserAdminBundle')
        );
        $builder->add(
            'expired',
            'checkbox',
            array('label' => 'form.expired', 'translation_domain' => 'BcUserAdminBundle')
        );
        $builder->add(
            'expiresAt',
            'datetime',
            array(
                'date_widget'           => 'single_text',
                'time_widget'           => 'single_text',
                'label'                 => 'form.expiresAt',
                'translation_domain'    => 'BcUserAdminBundle'
            )
        );
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('update'),
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'updateUser';
    }
}
