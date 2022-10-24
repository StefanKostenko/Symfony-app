<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\Tienda;

class ProductoType extends AbstractType

{

    public function buildForm(FormBuilderInterface $builder, array $options)

    {
        $builder
            ->add('producto', TextType::class)
            ->add('modelo', TextType::class)
            ->add('caracteristicas', TextType::class)
            ->add('precio', TextType::class)
            ->add('tienda', EntityType::class , array('class' => Tienda::class, 'choice_label' => 'nombre',))
            ->add('save', SubmitType::class, array('label' => 'Enviar'));
    }

}