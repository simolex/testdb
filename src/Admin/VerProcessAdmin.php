<?php

namespace App\Admin;

use App\Entity\VerBlocks;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

//use Symfony\Component\Form\FormEvent;
//use Symfony\Component\Form\FormEvents;

use App\Admin\EventListener\AddNameFieldSubscriber;

final class VerProcessAdmin extends AbstractAdmin
{
	protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        	->add('note', TextType::class)
        	->add('parentId', TextType::class);

        $formMapper->getFormBuilder()
            ->addEventSubscriber(new AddNameFieldSubscriber());
            /*->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $id_ver_block = $event->getData();
                $form = $event->getForm();

                // проверяет, является ли объект Продукт "новым"
                // Если в форму не были переданы данные, то данные - "null".
                // Это должно быть воспринято, как новый "Продукт"
                if (!$id_ver_block || null === $id_ver_block->getId()) {
                    $form->add('idVerBlock', TextType::class);
                }
        });*/
            /*->add('idVerBlock', EntityType::class,[
                'class' => VerBlocks::class,
                'choice_label' =>'attr',
            ])*/




    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('note')
            ->addIdentifier('parentId')
            ->addIdentifier('idVerBlock')
        ;
    }
}