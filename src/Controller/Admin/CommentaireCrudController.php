<?php

namespace App\Controller\Admin;

use App\Entity\Commentaire;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CommentaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commentaire::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $detail = Action::new('detail','Details') //'fa fas-book-open'
        ->linkToCrudAction(Crud::PAGE_DETAIL)
            //->AddCssClass('btn btn-info')
        ;

        return $actions
            ->add(Crud::PAGE_INDEX, $detail)
            ->disable(Action::NEW)
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('blogpost'),
            AssociationField::new('peinture'),
            AssociationField::new('user'),
            TextField::new('auteur')->hideOnForm(),
            EmailField::new('email')->onlyOnForms(),
            DateField::new('createdAt'),
            TextareaField::new('contenu'),
            BooleanField::new('isPublished'),
        ];
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Commentaires')
            ->setPageTitle('edit', 'Editer le commentaire')
            ->setDefaultSort(['createdAt' => 'DESC']);
    }
}
