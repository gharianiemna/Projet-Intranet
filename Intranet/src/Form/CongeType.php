<?php

namespace App\Form;
use App\Entity\User;
use App\Entity\Conge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\GreaterThan;

class CongeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DateDebut', DateType::class,  ['label' => 'Date De Début'], [
                'required' => true,
            ])
            ->add('nbJours' ,NumberType::class,['label' => 'Nombre du jour '],[
                'constraints'=> [new LessThan([
                    'value' => 22]),
                    new GreaterThan([
                        'value' => 0
                    ])
                    ]
            ])
            ->add('valider', SubmitType::class,['label' => 'Soumettre']);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Conge::class,
        ]);
    }
}
