<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('last_name', TextType::class, [
                "label" => "Nom",
                "required" => true,
            ])
            ->add('first_name', TextType::class, [
                "attr" => [
                    "class" => "FIRSTNAMECLASS"
                ],
                "label" => "Prénom",
                "required" => true,
            ])
            ->add('email', EmailType::class, [
                "label" => "Email",
                "required" => true,
            ])
            ->add('subject', TextType::class, [
                "label" => "Objet du message",
                "required" => true,
            ])
            ->add('body', TextareaType::class, [
                "label" => "Votre message",
                "required" => true,
            ])
            ->add('submit', SubmitType::class, [
                "label" => "Envoyer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
