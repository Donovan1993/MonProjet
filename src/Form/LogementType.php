<?php

namespace App\Form;

use App\Entity\Logement;
use PhpParser\Builder\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType as TypeIntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LogementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Nom du logement'))
            ->add('description')
            ->add('surface')
            ->add('rooms', TypeIntegerType::class, array('label' => 'Nbr de pièces'))
            ->add('bedrooms', TypeIntegerType::class, array('label' => 'Nbr de chambres'))
            ->add('floor', TypeIntegerType::class, array('label' => 'Etages'))
            ->add('price', TypeIntegerType::class, array('label' => 'Prix'))
            ->add('heat')
            /*->add('options', EntityType::class, [
                'class' => Option::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => true
            ]) */
            ->add('imageFile', FileType::class, [
                'required' => false
            ])
            ->add('city', TextType::class, array('label' => 'Ville'))
            ->add('address', TextType::class, array('label' => 'Adresse'))
            ->add('postal_code', TextType::class, array('label' => 'Code postal'))
            ->add('sold', CheckboxType::class, array('label' => 'Dispo'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Logement::class,
            'translation_domain' => 'forms'
        ]);
    }

    private function getChoices()
    {
        $choices = Logement::HEAT;
        $output = [];
        foreach ($choices as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }
}
