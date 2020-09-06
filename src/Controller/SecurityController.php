<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Form\RegistrationType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
   public function registration(MailerInterface $mailer, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder ) {
       $user = new User();
       $form = $this->createForm(RegistrationType::class, $user );

       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success','Votre inscription s\'est déroulée à merveille ! Un email vous a été envoyé !');
           $hash = $encoder->encodePassword($user, $user->getPassword());

           $user->setPassword($hash);

           $manager->persist($user);
           $manager->flush();

           $email = (new Email())
                ->from('paddle_rent@rent.com')
                ->to($user->getEmail())
                ->subject('Bienvenue')
                ->text("Bienvenue à toi {$user->getUsername()} ! sur notre super site de location de paddles");

            $mailer->send($email);
           return $this->redirectToRoute('login');
       }
       return $this->render('security/registration.html.twig', [
           'form' => $form->createView()
       ]);

   }
  
   /**
    * @Route("/logout", name="app_logout")
    */
   public function logout()
   {
    return $this->redirectToRoute('logout_message');
   }
    /**
    * @Route("/logout_success", name="logout_message")
    */
    public function logoutMessage() {
        $this->addFlash('success',"À bientôt l'ami !");
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
}
