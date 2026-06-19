<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Editor;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'by_reference' => false,
                'label' => 'Auteur(s)'
            ])
            ->add('editor', EntityType::class, [
                'class' => Editor::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'by_reference' => false,
                'label' => 'Editeur'
            ])
            ->add('isbn', TextType::class, [
                'label' => 'ISBN'
            ])
            ->add("editedAt", DateType::class, [
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
                'label' => 'Date de sortie',
            ])
            ->add('plot', TextType::class, [
                'label' => 'Synopsis'
            ])
            ->add('pageNumber', TextType::class, [
                'label' => 'Nombre de Pages'
            ])
            ->add('coverImage', FileType::class, [
                'label' => 'Couverture',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File(
                        maxSize: '5M',
                        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
                        mimeTypesMessage: 'Formats acceptés : JPG, PNG, WEBP'
                    )
                ],
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