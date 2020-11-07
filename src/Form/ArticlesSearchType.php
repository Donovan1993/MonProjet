<?php

namespace App\Form;

use App\Entity\ArticlesSearch;
use DateTime;
use Doctrine\ORM\Query\AST\UpdateItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\WeekType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ArticlesSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minPublished', WeekType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Date de creation'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ArticlesSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }
}
