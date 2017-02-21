<?php
namespace Incentives\OperacionesBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use PUGX\AutocompleterBundle\Form\Type\AutocompleteType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Incentives\OperacionesBundle\Form\Type\AeconomicaType;

class AddAeconomicaFieldSubscriber implements EventSubscriberInterface
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
        if ($data ) {
            $form->add('aeconomica', CollectionType::class, array(
				'entry_type' 	=> AeconomicaType::class,
                'label'          => 'Actividad economica',
                'by_reference'   => false,
                //'prototype_data' => new Address(),
                'allow_delete'   => true,
                'allow_add'      => true
			));
        }
    }
}
