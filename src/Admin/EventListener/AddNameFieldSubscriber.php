<?php

namespace App\Admin\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AddNameFieldSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // Сообщает диспетчеру, что вы хотите слушать событие form.pre_set_data
        // и что должен быть вызван метод preSetData.
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    public function preSetData(FormEvent $event)
    {
        $product = $event->getData();
        $form = $event->getForm();

        if (!$product || null === $product->getId()) {
            $form->add('idVerBlock', TextType::class);
        }
    }
}