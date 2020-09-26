<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('author'),
            TextEditorField::new('text')
                ->hideOnIndex(),
            TextField::new('email'),
            DateTimeField::new('createdAt')
                ->formatValue(function (string $value, Comment $comment) {
                    return $comment->getCreatedAt()->format('d. m. Y');
                }),
            AssociationField::new('conference')
                ->hideOnIndex(),
            TextField::new('photoFilename')
                ->hideOnIndex(),
        ];
    }
}
