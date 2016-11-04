<?php

namespace Practica2Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CountrylanguageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('language',   TextType::class, array("required"=>"required"))
            ->add('isofficial', TextType::class, array("required"=>"required"))
            ->add('percentage', NumberType::class, array("required"=>"required"))
            ->add('countrycode',EntityType::class,
                                      array('class'=>'Practica2Bundle:Country',
                                            'choice_label'=>'code'))
            ->add('Guardar',    SubmitType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Practica2Bundle\Entity\Countrylanguage'
        ));
    }
}
