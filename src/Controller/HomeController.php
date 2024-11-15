<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class HomeController extends AbstractController
{
    private $router;
    private $translator;

    public function __construct(UrlGeneratorInterface $router, TranslatorInterface $translator)
    {
        $this->router = $router;
        $this->translator = $translator;
    }


    #[Route('/{page}', name: 'app_home')]
    public function index(string $page = null): Response
    {
        if (!$page) {
            $page = "readme";
        }
            
        return $this->render('home/index.html.twig', [
            'page' => array(
                'menu' => array(
                    'category' => 'home',
                    'item' => 'dashboard'
                ),
                'pretitle' => $this->translator->trans("Home"),
                'title' => $this->translator->trans("Documentation"),
                'template' => "documentation/".$page.".md",
                'actions' => array(),
            ),
            'breadcrumbs' => array(array('name' => $this->translator->trans("Home"), 'url' => $this->router->generate('app_home'))),
        ]);
    }

    #[Route('/samplemd', name: 'app_samplemd')]
    public function samplemd(): Response
    {
        return $this->render('home/index.html.twig', [
            'page' => array(
                'menu' => array(
                    'category' => 'home',
                    'item' => 'dashboard'
                ),
                'pretitle' => $this->translator->trans("Home"),
                'title' => $this->translator->trans("Documentation"),
                'template' => "sample/markdown.md",
                'actions' => array(),
            ),
            'breadcrumbs' => array(array('name' => $this->translator->trans("Home"), 'url' => $this->router->generate('app_home'))),
        ]);
    }
}
