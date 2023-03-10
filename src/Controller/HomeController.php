<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $server=$_SERVER["SERVER_NAME"];
        switch($server){
            case 'www.ali.stage-cda.fr':
            $html='home/ali.html.twig';
                break;
            case 'www.christopher.stage-cda.fr':
            $html='home/christopher.html.twig';
                break;
            default:
            $html='home/index.html.twig';
                break;
        }
        return $this->render("$html", [
            'controller_name' => 'HomeController',
        ]);
    }
}