<?php

namespace SymfonyContrib\Bundle\EmailTemplateBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Email template form.
 */
class EmailTemplateForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('from', 'email', [
                'required' => false,
            ])
            /*
            ->add('cc', 'collection', [
                'type'         => 'email',
                'allow_add'    => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'options'      => [
                    'required' => false,
                    'label'    => false,
                ],
            ])
            ->add('bcc', 'collection', [
                'type'         => 'email',
                'allow_add'    => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'options'      => [
                    'required' => false,
                    'label'    => false,
                ],
            ])
            */
            ->add('subject', 'text')
            ->add('htmlBody', 'textarea', [
                'attr' => [
                    'rows' => 10,
                ],
            ])
            ->add('txtBody', 'textarea', [
                'attr' => [
                    'rows' => 10,
                ],
            ])
            ->add('save', 'submit', [
                'attr' => [
                    'class' => 'btn-primary',
                ],
            ])
            ->add('cancel', 'button', [
                'url' => $options['cancel_url'],
            ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'SymfonyContrib\Bundle\EmailTemplateBundle\Entity\EmailTemplate',
            'cancel_url' => '/',
        ]);
    }

    public function getName()
    {
        return 'email_template_form';
    }
}
