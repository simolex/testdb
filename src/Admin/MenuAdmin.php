<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Menu;
use App\Entity\MenuType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

final class MenuAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('title')
            ->add('id')
            ->add('route')
        ;

    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->addIdentifier('title')
            ->add('route')
            ->add('parent.title')
            ->add('menuTypeId.title')

            /*->add('menuTypeId',null, [], EntityType::class, [
                'class' => MenuType::class,
                'choice_label' => 'title'
            ])*/
        ;
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            //->add('id')
            ->add('title')
            ->add('route')
            ->add('alias')
            ->add('static', null, ['required' => false,])
            ->add('menuTypeId', ModelType::class, [
                'class' => MenuType::class,
                'property' => 'title',
                'required' => false,
            ])
            ->add('parent', ModelType::class, [
                'class' => Menu::class,
                'property' => 'title',
                'required' => false,
            ])
        ;

    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('title')
            ->add('id')
            ->add('route')
        ;
    }
}
