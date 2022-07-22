<?php

namespace App\Controller;

use App\Entity\Cv;
use App\Form\CvType;
use App\Repository\CvRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use symfony\component\httpfoundation\ResponseHeaderBag;
class CooptationController extends AbstractController
{
    /**
     * @Route("/cooptation", name="app_cooptation")
     */
    public function addCv(Request $request,EntityManagerInterface $em): Response
    {
        $succes = false;
        $cv = new Cv();
        $form = $this->createForm(CvType::class,$cv);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $fileName = $form->get('fileName')->getData();
            $originalFilename = pathinfo($fileName->getClientOriginalName(), PATHINFO_FILENAME);
                // $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$fileName->guessExtension();

                $fileName->move(
                    $this->getParameter('cvs_directory'),
                    $newFilename
                );

                $cv->setFileName($newFilename);
                $cv->setUser($this->getUser());
                $em->persist($cv);
                $em->flush();
                $succes = true;
        }
        return $this->render('cooptation/index.html.twig', [
            'form' => $form->createView(),
            'succes' => $succes
        ]);
    }
    /**
     * @Route("/admin/cooptation", name="app_admin_cooptation")
     */
    public function showcooptations(CvRepository $CvRepository )
   

    {   
       
        $cv = $CvRepository->findAll();
       
        return $this->render('cooptation/showcooptation.html.twig',["cv" => $cv]);
    }

 
}
