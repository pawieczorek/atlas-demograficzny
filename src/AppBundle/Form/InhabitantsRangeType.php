<?php
// src/AppBundle/Form/InhabitantsRangeType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class InhabitantsRangeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minNumber')
            ->add('maxNumber')
            ->add('save', 'submit')
        ;
    }

    public function getName()
    {
        return 'app_InhabitantsRangeType';
    }
}
?>