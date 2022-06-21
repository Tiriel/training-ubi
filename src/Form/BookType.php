<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isbn', TextType::class, [
                'attr' => ['placeholder' => 'ISBN']
            ])
            ->add('title', TextType::class, [
                'attr' => ['placeholder' => 'The book\'s title']
            ])
            ->add('releasedAt', DateType::class, [
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
            ])
            ->add('author', TextType::class, [
                'attr' => ['placeholder' => 'The author\'s name'],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 5])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
