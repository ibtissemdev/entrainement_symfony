<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class UrlService {

private EntityManagerInterface $em ;

 public function __construct(EntityManagerInterface $em) {
$this->em = $em;

 }  
 
 public function addUrl(string $longUrl) {
    
 }
}