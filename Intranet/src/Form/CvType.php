<?php

namespace App\Form;

use App\Entity\Cv;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fileName',FileType::class,[
                'label' => 'CV (pdf,word,image)',
                'mapped' => false,
                'required' => true,
                'constraints' => new File([
                    'mimeTypes' => [
                        'application/pdf',
                        'application/x-pdf',
                        'image/*',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                    ],
                    'mimeTypesMessage' => 'Please upload a valid format file (pdf,image,word)'
                ]),
            ])
            ->add('soumettre',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cv::class,
        ]);
    }
}
