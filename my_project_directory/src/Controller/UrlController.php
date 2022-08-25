<?php

namespace App\Controller;

use App\Service\UrlService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UrlController extends AbstractController
{
    private UrlService $urlService;

    public function __construct(UrlService $urlService)
    {
        $this->urlService = $urlService;
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
    public function add(Request $request)
    { // paramètre d'une requête POST
        $longUrl = $request->request->get('url');

        $this->urlService->addUrl($longUrl);
    }
}
