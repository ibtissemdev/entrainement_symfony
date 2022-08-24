<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UrlController extends AbstractController
{
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
    public function add (Request $request)
    {
$longUrl=$request->request->get('url');
    }
}
