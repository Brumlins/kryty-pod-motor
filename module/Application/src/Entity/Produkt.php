<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "produkty")]
class Produkt
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue]
    private $id;
    
    #[ORM\Column(type: "string", length: 10)]
    private $kod;
    
    #[ORM\ManyToOne(targetEntity: "Znacka")]
    #[ORM\JoinColumn(name: "znacka_id", referencedColumnName: "id")]
    private $znacka;
    
    #[ORM\ManyToOne(targetEntity: "Material")]
    #[ORM\JoinColumn(name: "material_id", referencedColumnName: "id")]
    private $material;
    
    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private $cena;
    
    #[ORM\Column(type: "text", nullable: true)]
    private $popis;
    
    #[ORM\Column(type: "datetime", name: "vytvoreno")]
    private $vytvoreno;
    
    public function __construct()
    {
        $this->vytvoreno = new \DateTime();
    }
    
    // Getters and setters
    public function getId()
    {
        return $this->id;
    }
    
    public function getKod()
    {
        return $this->kod;
    }
    
    public function setKod($kod)
    {
        $this->kod = $kod;
        return $this;
    }
    
    public function getZnacka()
    {
        return $this->znacka;
    }
    
    public function setZnacka($znacka)
    {
        $this->znacka = $znacka;
        return $this;
    }
    
    public function getMaterial()
    {
        return $this->material;
    }
    
    public function setMaterial($material)
    {
        $this->material = $material;
        return $this;
    }
    
    public function getCena()
    {
        return $this->cena;
    }
    
    public function setCena($cena)
    {
        $this->cena = $cena;
        return $this;
    }
    
    public function getPopis()
    {
        return $this->popis;
    }
    
    public function setPopis($popis)
    {
        $this->popis = $popis;
        return $this;
    }
    
    public function getVytvoreno()
    {
        return $this->vytvoreno;
    }
}
