<?php

namespace App\Controller;

use App\Repository\ActualityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class ActualityController extends AbstractController
{
    /**
     * @Route("/actuality", name="app_actuality")
     */
    public function actuality(ActualityRepository $actuRepo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $count = $actuRepo->count([]);


        if(isset($_GET['page'])){
            $page = $_GET['page'];
            $act = $actuRepo->findByPage($page-1);
        }
        else{
            $act = $actuRepo->findByPage(0);
            $page = 1;
        }

        return $this->render('actuality/index.html.twig', [
            'actu' => $act,
            'nb_page' => ceil($count/5),
            'page' => $page
        ]);
    }
}
