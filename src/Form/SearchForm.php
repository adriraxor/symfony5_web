<?php


namespace App\Form;


use App\Data\SearchData;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('keyword', TextType::class, [
                'label' =>false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher un produit',
                    'autocomplete' => 'off',
                ]
            ])
            ->add('categories', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Categorie::class,
                'expanded' => true,
                'multiple' => true
            ])
            ->add('min_price', RangeType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'min' => 1,
                    'max' => 50,
                    'value' => 1,
                ],
            ])
            ->add('max_price', RangeType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'min' => 50,
                    'max' => 100,
                    'value' => 100,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

}