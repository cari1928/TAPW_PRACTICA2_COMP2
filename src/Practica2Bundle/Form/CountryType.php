<?php

namespace Practica2Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CountryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',           TextType::class, array("required"=>"required"))
            ->add('continent',      TextType::class)
            ->add('region',         TextType::class)
            ->add('surfacearea',    NumberType::class)
            ->add('indepyear',      NumberType::class)
            ->add('population',     NumberType::class)
            ->add('lifeexpectancy', NumberType::class)
            ->add('gnp',            MoneyType::class)
            ->add('gnpold',         MoneyType::class)
            ->add('localname',      TextType::class)
            ->add('governmentform', TextType::class)
            ->add('headofstate',    TextType::class)
            ->add('code2',          TextType::class)
            ->add('capital',        EntityType::class,
                                      array('class'=>'Practica2Bundle:City',
                                            'choice_label'=>'name'))
            ->add('Guardar',       SubmitType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Practica2Bundle\Entity\Country'
        ));
    }
}
