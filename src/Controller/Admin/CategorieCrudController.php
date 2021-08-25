<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categorie::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $detail = Action::new('detail','Voir') //'fa fas-book-open'
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
            TextField::new('nom'),
            TextareaField::new('description'),
            SlugField::new('slug')->setTargetFieldName('nom')->hideOnIndex(),
            TextField::new('imageFile')->setFormType(VichImageType::class),
            ImageField::new('file')->setBasePath('/uploads/peintures')->onlyOnIndex(),
            DateTimeField::new('createdAt')->hideOnForm(),

        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Catégories')
            ->setPageTitle('new', 'Créer une nouvelle catégorie')
            ->setPageTitle('edit', 'Editer la catégorie')
            ->setDefaultSort(['createdAt' => 'DESC']);
    }

}
