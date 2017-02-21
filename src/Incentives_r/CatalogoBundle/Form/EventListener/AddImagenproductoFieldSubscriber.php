<?php
namespace Incentives\CatalogoBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Incentives\CatalogoBundle\Form\Type\ImagenproductoType;

class AddImagenproductoFieldSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // Informa al despachador que deseas escuchar el evento
        // form.pre_set_data y se debe llamar al método 'preSetData'.
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        // check if the product object is "new"
        // If you didn't pass any data to the form, the data is "null".
        // This should be considered a new "Product"
        if (!$data || !$data->getId()) {
            $form->add('imagenproducto', 'collection', array(
            'type'  => new ImagenproductoType(),
            'label'          => 'Imagen producto',
            'by_reference'   => false,
            'allow_delete'   => true,
            'allow_add'      => true
        ));
        }
    }
}
