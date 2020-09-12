<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\RentAd;
use App\Form\RentAdType;
use App\Form\ContactType;
use App\Repository\RentAdRepository;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

use Doctrine\ORM\EntityManagerInterface;

class RentController extends AbstractController
{
    /**
     * @Route("/rent", name="rent")
     */
    public function index(RentAdRepository $repo, Request $request, PaginatorInterface $paginator)
    {   
        $data = $repo->findAll();
        $rentAds = $paginator->paginate(
            $data, // Requête contenant les données à paginer (ici nos annonces)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );
        return $this->render('rent/index.html.twig', [
            'controller_name' => 'RentController',
            'rentAds' => $rentAds
        ]);
    }

    /**
     *  @Route("/", name="home")
     */
    public function home() {
        return $this->render('rent/home.html.twig');
    }

     /**
     * @Route("/new", name="rent_create")
     * @Route("/{id}/edit", name="rent_edit")
     */
    public function form (RentAd $rentAd = null , Request $request , EntityManagerInterface $manager) {
            
        if(!$rentAd) {
            $rentAd = new RentAd();
        }
        $form = $this->createForm(RentAdType::class, $rentAd);
    
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            if(!$rentAd->getId()){
                $rentAd->setCreatedAt(new \DateTime());
            }
            $rentAd->setUser($this->getUser());
            $fileUpload = $rentAd->getImage();
            $fileName = md5(uniqid()).'.'.$fileUpload->guessExtension();
            $fileUpload->move($this->getParameter('upload_directory'), $fileName);
            $rentAd->setImage($fileName);

            $manager->persist($rentAd);
            $manager->flush();

            return $this->redirectToRoute('rent_show', [
                'id' => $rentAd->getId()
                ]);
        }

        return $this->render('rent/create.html.twig' , [
            'formRentAd' => $form->createView(),
            'editMode' => $rentAd->getId() !== null,
            'rentAd' => $rentAd
            ]);
    }

    /**
     *  @Route("/rent/{id}", name="rent_show")
     */
    public function showPublic(RentAd $rentAd, Request $request, MailerInterface $mailer) {
       
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
      
        $form->handleRequest($request);
        
            if($form->isSubmitted() && $form->isValid()) {

                $this->addFlash('success','Votre email a bien été envoyé !');

                $notification = (new Email())
                    ->from('paddle_rent@rent.com')
                    ->to($contact->getmail())
                    ->subject('notification')
                    ->text("votre email à bien été envoyé");

                $mailer->send($notification);

                $message = (new Email())
                    ->from($contact->getmail())
                    ->to($contact->getTo())
                    ->subject('Location')
                    ->text($contact->getMessage());

                $mailer->send($message);

                return $this->redirectToRoute('rent', [
                    'rentAd' => $rentAd,
                    ]);
                
            }
            return $this->render('rent/showPublic.html.twig', [
                'rentAd' => $rentAd,
                'contactForm' => $form->createView(),
                ]);
    }

    /**
     * @Route("/myrentads", name="my_rent_ads")
     */
   public function showMyAds (RentAdRepository $repo) {

        $myRentAds = $repo->findBy([
            'user' => $this->getUser()->getId()
        ]);
        return $this->render('rent/showMyAds.html.twig', [
            'controller_name' => 'RentController',
            'myRentAds' => $myRentAds
        ]);
   }
    /**
     * @Route("/myrentads/{id}/delete", name="delete_ad")
     */
   public function deleteAd(EntityManagerInterface $manager, RentAd $rentAd) {

        $manager->remove($rentAd);
        $manager->flush();

        return $this->redirectToRoute('my_rent_ads');
   }
    /**
     * @Route("/contact", name="contact_us")
     */
    public function contactUs( MailerInterface $mailer, Request $request) {
        $rentAd = new RentAd();
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
      
        $form->handleRequest($request);
        
            if($form->isSubmitted() && $form->isValid()) {

                $this->addFlash('success','Votre email a bien été envoyé !');

                $contactUs = (new Email())
                    ->from($contact->getmail())
                    ->to('paddle_rent@rent.com')
                    ->subject('contact')
                    ->text($contact->getMessage());

                $mailer->send($contactUs);

                return $this->redirectToRoute('rent');

            }
            return $this->render('/rent/contact.html.twig', [
                'rentAd' => $rentAd,
                'contactForm' => $form->createView()
                ]);
    }   
}
                
