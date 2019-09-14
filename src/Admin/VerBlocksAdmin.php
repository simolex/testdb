<?php

namespace App\Admin;

use App\Entity\VerKinds;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
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
            /*->add('name', ModelType::class, [
                'class' => VerKinds::class,
                'property' => 'name',
            ])*/
            ->add('Type', TextType::class)
            ->add('Attr', TextType::class)
            ->add('Message', TextType::class)
            ->add('blockType', TextType::class)
            ->add('klsCode', TextType::class)

        ;


    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('Type')
            ->addIdentifier('Attr')
            ->addIdentifier('Message')
            ->addIdentifier('blockType')
            ->addIdentifier('klsCode')
        ;
    }
}