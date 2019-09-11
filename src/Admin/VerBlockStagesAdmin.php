<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

final class VerBlockStagesAdmin extends AbstractAdmin
{
	protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        	->add('idBlType', TextType::class)
        	->add('orders', TextType::class)
        	->add('pubName', TextType::class)
        	->add('descNote', TextType::class)
        	->add('sysName', TextType::class)
        ;


    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('pubName');
    }
}