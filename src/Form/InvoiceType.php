<?php

namespace App\Form;

use App\Entity\Invoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresse_facturation', TextType::class, [
                'label' => 'Adresse de facturation'
            ])
            ->add('ville_de_facturation', TextType::class, [
                'label' => 'Ville de facturation'
            ])
            ->add('code_postal', IntegerType::class, [
                'label' => 'Code postal'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Finaliser la commande'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);
    }
}
