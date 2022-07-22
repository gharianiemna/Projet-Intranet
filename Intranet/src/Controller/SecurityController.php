<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if($this->getUser()){
        if ($this->getUser()->getRoles() == ["ROLE_USER"] ){
            return $this->redirectToRoute('app_actuality');
        }
        elseif($this->getUser()->getRoles() == ["ROLE_ADMIN"])
         { return $this->redirectToRoute('AddUser');} }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
     /**
     * @Route("/create", name="app_user")
     */
    public function createAdmin(UserPasswordEncoderInterface $pwdEncoder)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setEmail("admin@talan.com")
            ->setFirstname ("rania")
            ->setLastname ("ammari");
            

        $hashedPwd = $pwdEncoder->encodePassword($user, 123);
        $user->setPassword($hashedPwd);
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->render('security/login.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
     /**
     * @Route("/access-denied", name="app_access_denied")
     */
    //  public function accessDenied()
    // {
    // if ( $this->getUser() ) {
    //     return $this->redirectToRoute("app_register");
    // }

    //  return $this->redirectToRoute('app_login');
    // }
}
