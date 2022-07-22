<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Omines\DataTablesBundle\DataTableFactory;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Symfony\Component\HttpFoundation\JsonResponse;


class AdminController extends AbstractController
{
    /**
     * @Route("/user", name="app_admin")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    /**
     * @Route("/AddUser", name="AddUser")
     */
    public function AddUser(DataTableFactory $dataTableFactory,Request $request, ManagerRegistry $doctrine, UserPasswordEncoderInterface $userPasswordEncoder): Response
     {
        $User = new User();
        $form = $this->createForm(RegistrationType::class, $User);
        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $User->setRoles(['ROLE_USER']);
                $entityManager = $doctrine->getManager();
                $User->setPassword(
                    $userPasswordEncoder->encodePassword(
                            $User,
                            $form->get('password')->getData()
                        )
                    );       
                $entityManager->persist($User);
                $entityManager->flush();  
                $this->addFlash('success', 'Created! ');
                return $this->redirectToRoute('AddUser');
            }

            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            $table = $dataTableFactory->create()
            ->add('firstname', TextColumn::class,['label' => 'Nom', 'className' => 'bold'])
            ->add('lastname', TextColumn::class,['label' => 'Prénom', 'className' => 'bold'])
            ->add('email', TextColumn::class,['label' => 'Email', 'className' => 'bold'])
            ->createAdapter(ORMAdapter::class, [
                'entity' => User::class,
    
            ])
            ->handleRequest($request);
    
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('admin/adduser.html.twig', [
            'form' => $form->createView(),'datatable' => $table

        ]);
        } 
        
    /**
     * @Route("/ajax", name="ajax")
     */
    public function ShowUsers(UserRepository $user){
        $user->findAll();
        return $user;
        
    }
}
