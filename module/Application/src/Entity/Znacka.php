<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "znacka")]
class Znacka
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue]
    private $id;
    
    #[ORM\Column(type: "string", length: 100)]
    private $nazev;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getNazev()
    {
        return $this->nazev;
    }
    
    public function setNazev($nazev)
    {
        $this->nazev = $nazev;
        return $this;
    }
    public function __toString()
    {
        return $this->getNazev() ?: '';
    }

}
