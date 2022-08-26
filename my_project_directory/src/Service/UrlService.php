<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Url;

class UrlService
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function addUrl(string $longUrl): Url
    {
        $url = new Url();
        $hash = $this->generateHash();
        $link = $_SERVER['HTTP_ORIGIN'] . "/$hash";

        $url->setHash($hash);
        $url->setLink($link);
$url->setCreatedAd(new \DateTime);

$this->em->persist($url);

        return $url;
    }

    public function generateHash(int $offset = 0, int $lenght = 8): string
    {
        return substr(md5(mt_rand(), true), $offset, $lenght); //pour générer un hash aléatoire
    }
}
