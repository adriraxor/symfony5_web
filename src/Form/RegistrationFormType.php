<?php

namespace App\Form;

use App\Entity\Client;
use App\Validator\UniqueEmail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Adresse Email',
                    'autocomplete' => 'off',
                ],
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'minMessage' => 'L\'email doit comporter au minimum {{ limit }} caractères',
                        'maxMessage' => 'L\'email doit comporter au maximum {{ limit }} caractères',
                        'max' => 30,
                    ]),
                ],
            ])
            ->add('country', ChoiceType::class, [
                'label' => 'Région code : (exemple : FR = France, ES = Espagne)',
                'choices' => json_decode(
                    file_get_contents(__DIR__ . '/../Data/countries-FR.json'), true
                )
            ])
            ->add('num_tel', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Numéro de téléphone',
                    'autocomplete' => 'off',
                    'maxlength' => '10',
                ],
                'constraints' => [
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Le numéro de téléphone doit comporter au minimum {{ limit }} caractères',
                        'maxMessage' => 'Le numéro de téléphone doit comporter au maximum {{ limit }} caractères',
                        'max' => 10,
                    ]),
                ],
            ])
            ->add('pseudo', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Pseudonyme',
                    'autocomplete' => 'off',
                ],
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Le pseudo doit comporter au minimum {{ limit }} caractères',
                        'maxMessage' => 'Le pseudo doit comporter au maximum {{ limit }} caractères',
                        'max' => 20,
                    ]),
                ],
            ])
            ->add('nom', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom de famille',
                    'autocomplete' => 'off',
                ],
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Le nom de famille doit comporter au minimum {{ limit }} caractères',
                        'maxMessage' => 'Le nom de famille doit comporter au maximum {{ limit }} caractères',
                        'max' => 20,
                    ]),
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prénom',
                    'autocomplete' => 'off',
                ],
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Le prénom doit comporter au minimum {{ limit }} caractères',
                        'maxMessage' => 'Le prénom doit comporter au maximum {{ limit }} caractères',
                        'max' => 20,
                    ]),
                ],
            ])
            ->add('photoProfil', FileType::class, [
                'required' => true,
                'attr' => [
                    'accept' => 'image/png, image/jpeg, image/gif',
                    'onchange' => 'processSelected(this)',
                    'placeholder' => 'Sélectionnez une photo de profil',
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => false,
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Mot de passe (6 carac. min)',
                    'autocomplete' => 'off',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au minimum {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
