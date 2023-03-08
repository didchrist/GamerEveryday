<?php

namespace App\Form;

use App\Entity\GameGroup;
use App\Entity\Group;
use App\Entity\UserGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameGroup',TextType::class,[
                'label'=>'Nom du groupe: ',
                ])    
            ->add('accesGroup',CheckboxType::class,[
                'label'=>'Accés au groupe: ',
                ])    
            ->add('descriptionGroup',TextType::class,[
                'label'=>'Description du groupe: ',
                ])    
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Group::class,
        ]);
    }
}
