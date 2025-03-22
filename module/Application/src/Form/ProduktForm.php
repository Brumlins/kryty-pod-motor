<?php
namespace Application\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Doctrine\ORM\EntityManager;
use Application\Entity\Znacka;
use Application\Entity\Material;
use DoctrineModule\Form\Element\ObjectSelect;

class ProduktForm extends Form
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('produkt');

        $this->entityManager = $entityManager;

        $this->add([
            'name' => 'id',
            'type' => Element\Hidden::class,
        ]);

        $this->add([
            'name' => 'kod',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Kód produktu',
            ],
            'attributes' => [
                'required' => true,
                'maxlength' => 10,
            ],
        ]);

        $this->add([
            'name' => 'znacka',
            'type' => ObjectSelect::class,
            'options' => [
                'label' => 'Značka',
                'object_manager' => $this->entityManager,
                'target_class' => Znacka::class,
                'property' => 'nazev',
                'is_method' => true,
                'find_method' => [
                    'name' => 'findAll',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'material',
            'type' => ObjectSelect::class,
            'options' => [
                'label' => 'Materiál',
                'object_manager' => $this->entityManager,
                'target_class' => Material::class,
                'property' => 'nazev',
                'is_method' => true,
                'find_method' => [
                    'name' => 'findAll',
                ],
            ],
        ]);

        $this->add([
            'name' => 'cena',
            'type' => Element\Number::class,
            'options' => [
                'label' => 'Cena',
            ],
            'attributes' => [
                'required' => true,
                'step' => '0.01',
                'min' => '0',
            ],
        ]);

        $this->add([
            'name' => 'popis',
            'type' => Element\Textarea::class,
            'options' => [
                'label' => 'Popis',
            ],
            'attributes' => [
                'rows' => 5,
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Element\Submit::class,
            'attributes' => [
                'value' => 'Uložit',
                'id'    => 'submitbutton',
                'class' => 'btn',
            ],
        ]);
    }
}
