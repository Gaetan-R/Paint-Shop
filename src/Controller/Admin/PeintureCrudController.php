<?php

namespace App\Controller\Admin;

use App\Entity\Peinture;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Exception\VichUploaderExceptionInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PeintureCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Peinture::class;
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
            TextField::new('nom'),
            TextareaField::new('description'),
            DateField::new('dateRealisation'),
            NumberField::new('largeur')->hideOnIndex(),
            NumberField::new('hauteur')->hideOnIndex(),
            NumberField::new('prix'),
            BooleanField::new('enVente'),
            BooleanField::new('portfolio'),
            DateTimeField::new('createdAt')->hideOnForm(),
            SlugField::new('slug')->setTargetFieldName('nom')->hideOnIndex(),
            TextField::new('imageFile')->setFormType(VichImageType::class)->onlyWhenCreating(),
            ImageField::new('file')->setBasePath('/uploads/peintures/')->onlyOnIndex(),
            AssociationField::new('categorie'),

        ];
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Peintures')
            ->setPageTitle('new', 'Créer une nouvelle peinture')
            ->setPageTitle('edit', 'Editer la peinture')
            ->setDefaultSort(['createdAt' => 'DESC']);
    }

}
