<?php

namespace App\Controller\Admin;

use App\Entity\Blogpost;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class BlogpostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Blogpost::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $detail = Action::new('detail','Details') //'fa fas-book-open'
            ->linkToCrudAction(Crud::PAGE_DETAIL)
            //->AddCssClass('btn btn-info')
            ;

        return $actions
            ->add(Crud::PAGE_INDEX, $detail)
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre'),
            TextField::new('slug')->hideOnForm()->hideOnIndex(),
            TextareaField::new('contenu'),
            DateTimeField::new('createdAt')->hideOnForm()->hideOnIndex(),
            DateField::new('publication'),
            SlugField::new('slug')->setTargetFieldName('titre')->hideOnIndex(),
            TextField::new('imageFile')->setFormType(VichImageType::class),
            ImageField::new('file')->setBasePath('/uploads/peintures/')->onlyOnIndex(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['createdAt' => 'DESC']);
    }

}
