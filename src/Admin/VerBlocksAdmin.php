<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\VerBlocks;

final class VerBlocksAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            /*->add(
                $formMapper->getFormBuilder()->add(
                    'verKind',
                    ChoiceType::class,
                    ['choices'  => VerBlocks::VER_KIND]
                ),
                ChoiceType::class
            )*/
            ->add('verType', TextType::class)
            ->add('attr', TextType::class)
            ->add('message', TextType::class)
            ->add('blockType', TextType::class)

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