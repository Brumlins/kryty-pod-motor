<?php
namespace Application\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Doctrine\ORM\EntityManager;
use Application\Entity\Znacka;
use Application\Entity\Material;

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
            'type' => Element\Select::class,
            'options' => [
                'label' => 'Značka',
                'value_options' => $this->getZnackyOptions(),
                'object_manager' => $this->entityManager,
                'target_class' => 'Application\Entity\Znacka',
                'property' => 'nazev',
            ],
        ]);
        

        $this->add([
            'name' => 'material',
            'type' => Element\Select::class,
            'options' => [
                'label' => 'Materiál',
                'property' => 'id',  
                'value_options' => $this->getMaterialyOptions(),
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

    private function getZnackyOptions()
    {
        $znacky = $this->entityManager->getRepository(Znacka::class)->findAll();
        $options = [];
        foreach ($znacky as $znacka) {
            $options[$znacka->getId()] = $znacka->getNazev();
        }
        return $options;
    }


    private function getMaterialyOptions()
    {
        $materialy = $this->entityManager->getRepository(Material::class)->findAll();
        $options = [];
        foreach ($materialy as $material) {
            $options[$material->getId()] = $material->getNazev();
        }
        return $options;
    }

}
