<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UrlRepository;
use App\Repository\UrlStatisticRepository;
use App\Service\UrlService;
use App\Service\UrlStatisticService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method User getUser()
 */


class UrlController extends AbstractController
{
    private UrlService $urlService;
    private UrlStatisticService $urlStatisticService;

    public function __construct(UrlService $urlService, UrlStatisticService $urlStatisticService)
    {
        $this->urlService = $urlService;
        $this->urlStatisticService = $urlStatisticService;
    }

    /**
     * @Route("/url", name="app_url")
     */
    public function index(): Response
    {
        return $this->render('url/index.html.twig', [
            'controller_name' => 'UrlController',
        ]);
    }


    /**
     * @Route("/ajax/shorten", name="url_add")
     */
    public function add(Request $request): Response
    { // paramètre d'une requête POST
        $longUrl = $request->request->get('url');

        if (!$longUrl) {
            return $this->json([
                'statusCode' => 400,
                'statusText' => 'MISSING_ARG_URL'
            ]);
        }
        $domain = $this->urlService->parseUrl($longUrl);
        if (!$domain) {
            return $this->json([
                'statusCode' => 500,
                'statusText' => 'INVALID_ARG_URL'
            ]);
        }
        $url = $this->urlService->addUrl($longUrl, $domain);

        return $this->json([
            'link' => $url->getLink(),
            'longUrl' => $url->getLongUrl()
        ]);
    }


    /**
     * @Route("/{hash}", name="url_view")
     */
    public function view($hash, UrlRepository $urlRepo): Response
    {

        $url = $urlRepo->findOneBy(['hash' => $hash]);

        if (!$url) { //S'il n'y a pas d'Url, on retourne l'utilisateur à la page d'accueil
            return $this->redirectToRoute('app_home');
        }

        if (!$url->getUser()) {
            return $this->redirect($url->getLongUrl());
        }

        $urlStatistic = $this->urlStatisticService->findOnByUrlAndDate($url, new \DateTime);

        $this->urlStatisticService->incrementUrlStatistic($urlStatistic);
        return $this->redirect($url->getLongUrl());
    }

    /**
     * @Route("/ajax/delete/{hash}", name="url_delete")
     */
    public function delete(string $hash): Response
    {
        return $this->urlService->deleteUrl($hash);
    }


    /**
     * @Route("/user/links", name="url_list")
     */
    public function list(): Response
    {

        $user = $this->getUser();
        if (!$user || $user->getUrls()->count() === 0) {
            return $this->redirectToRoute('app_home');
        }
        return $this->render('url/list.html.twig', [
            'urls' => $user->getUrls()
        ]);
    }

     /**
     * @Route("/statistics/{hash}", name="url_list")
     */
    public function statistics(string $hash, UrlRepository $urlRepo, UrlStatisticRepository $urlStatisticRepo) {

        $url = $urlRepo->findOneBy(['hash' => $hash]);
        if (!$url) {
            return $this->redirectToRoute('app_home');
        }
        $url_statistics = $urlStatisticRepo->findOneByUrl($url);
    }
}
