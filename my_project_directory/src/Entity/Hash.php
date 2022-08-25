<?php

namespace App\Entity;

use App\Repository\HashRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HashRepository::class)
 */
class Hash
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hash;


//méthode magique __set et _get
private $data=[]; 

    public function __set($propriete, $valeur):void {
$this->data[$propriete]=$valeur;
    }

    public function __get($propriete) {
if (in_array($propriete,$this->data)) {
    return $this->data[$propriete]; 
   
} else {
    echo 'propriété innexistante';
}
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }
}
