<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Url;
use Symfony\Component\Security\Core\Security;



class UrlService
{

    private EntityManagerInterface $em;
    private Security $security;

    public function __construct(EntityManagerInterface $em, Security $security)
    {
        $this->em = $em;
        $this->security=$security;
    }

    public function addUrl(string $longUrl, string $domain): Url
    {
        $url = new Url();

        
        $hash = $this->generateHash();
        $link = $_SERVER['HTTP_ORIGIN'] . "/$hash";
        $user = $this->security->getUser();

        $url->setLongUrl($longUrl);
        $url->setDomain($domain);

        $url->setHash($hash);
        $url->setLink($link);
        $user->setUser($user);
        $url->setCreatedAd(new \DateTimeImmutable);

        $this->em->persist($url); //Pour insérer dans la base de donnée
        $this->em->flush(); //synchroniser à la base de donée

        return $url;
    }

    public function parseUrl(string $url)
    {
        $domain = parse_url($url, PHP_URL_HOST);

        if (!$domain) {
            return false;
        }

        if (!filter_var(gethostbyname($domain), FILTER_VALIDATE_IP)) {
            return false;
        }
        return $domain;
    }

    public function generateHash(int $offset = 0, int $length = 8): string
    {
        return substr(md5(uniqid(mt_rand(), true)), $offset, $length); //pour générer un hash aléatoire
    }
}
