<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

final class VerBlocksAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper

            ->add('note', TextType::class)
            ->add('parentId', TextType::class)
            ->add('idVerBlock', EntityType::class,[
                'class' => VerBlocks::class,
                'choice_label' =>'attr',

            ])
        ;


    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('verType')
            ->addIdentifier('attr')
            ->addIdentifier('message')
            ->addIdentifier('blockType')
        ;
    }
}