<?php

namespace App\Controller;

use App\Entity\Conge;
use App\Form\CongeType;
use App\Repository\CongeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Omines\DataTablesBundle\DataTableFactory;
use Omines\DataTablesBundle\Column\TextColumn;
use Symfony\Component\Routing\Annotation\Route;
use Omines\DataTablesBundle\Column\DateTimeColumn;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;



class CongeController extends AbstractController
{
 /**
     * @Route("/conge", name="app_conge")
     */
    public function conge(Request $request, EntityManagerInterface $manager, CongeRepository $congeRepository )
    {
       
        $conge = new Conge();
        $user = $this->getUser();
        $form = $this->createForm(CongeType::class, $conge);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $conge->setUser($user);
            $conge->setStatut(['attente de validation']);
            $manager->persist($conge);
            $manager->flush();
        }
       

        $conge = $congeRepository ->findBy(array('user' => $user));

        return $this->render('conge/conge.html.twig', ['form' => $form->createView(), 'conge' => $conge,
    "user" => $user->getLastname()]);
    }
    /** 
     * @Route("/admin/conge", name="admin_conge")
     */
    public function afficheConge(Request $request, DataTableFactory $dataTableFactory)
    {
        $table = $dataTableFactory->create()
        ->add('user', TextColumn::class, ['label' => 'Utilisateur','field' => 'user.firstname'])
        ->add('DateDebut', DateTimeColumn::class, ['label' => 'Date Début','format' => 'd-m-Y'])
        ->add('nbJours', TextColumn::class, ['label' => 'Nombre de jour'])
        // ->add('Statut', TextColumn::class, ['label' => 'Statut'])
        ->add('Action', TextColumn::class, ['label' => 'Action','render' => '<button type="button" class="btn btn-success  btn-sm" >Accepter</button> <button type="button" class="btn btn-danger  btn-sm">Refuser</button>'])
        ->createAdapter(ORMAdapter::class, [
         'entity' => Conge::class,

        ])     
        ->handleRequest($request);
if ($table->isCallback()) {
    return $table->getResponse();
}
return $this->render('admin/adminConge.html.twig', ['datatable' => $table]);
    }
}





