<?php

namespace App\Controller;

use App\Entity\UserSession;
use App\Entity\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserSessionController extends AbstractController
{
    /**
     * @Route("/inscriptions/{session}/inscription", name="subscribe", requirements={"session":"\d+"})
     */
    public function subscribe(Session $session, EntityManagerInterface $entityManager)
    {
        $userSession = new UserSession();
        $userSession->setUser($this->getUser())
                    ->setSession($session)
                    ->setStatus("En cours")
        ;

        if($session->getUserSessions()->count() < $session->getMaxRegistration()) {
            $entityManager->persist($userSession);
            $entityManager->flush();

            $this->addFlash("success","L'inscription a bien été effectuée");

            return $this->redirectToRoute('displaySession', [
                'session' => $session->getId()
            ]);
        }

        $this->addFlash("error","Nombre maximum d'inscription déjà atteint");

        return $this->redirectToRoute('displaySession', [
            'session' => $session->getId()
        ]);
    }

    /**
     * @Route("/inscriptions/{userSession}/suppression", name="deleteRegistration", methods="DEL", requirements={"userSession":"\d+"})
     */
    public function deleteRegistration(UserSession $userSession, EntityManagerInterface $entityManager, Request $request)
    {
        if($this->isCsrfTokenValid("DEL". $userSession->getId(),$request->get('_token'))) {
            $entityManager->remove($userSession);
            $entityManager->flush();
            
            $this->addFlash("success","La suppression a bien été effectuée");
            
            return $this->redirectToRoute('displaySession', [
                'session' => $userSession->getSession()->getId()
            ]);
        }

        $this->addFlash("error","Une erreur est survenue lors de la suppression d'une inscription");

        return $this->redirectToRoute('displaySession', [
            'session' => $userSession->getSession()->getId()
        ]);
    }

    /**
     * @Route("/inscriptions/{userSession}/update", name="updateStatus", requirements={"userSession":"\d+"})
     */
    public function updateStatus(UserSession $userSession, Request $request, EntityManagerInterface $entityManager)
    {
        $status = $request->get('status');
  
        if($status) {
            $userSession->setStatus($status);
            $entityManager->persist($userSession);
            $entityManager->flush();

            $this->addFlash("success","Le statut a bien été modifié");
                
            return $this->redirectToRoute('displaySession', [
                'session' => $userSession->getSession()->getId()
            ]);
        }

        $this->addFlash("error","Le statut n'a pas pu être modifié");
            
        return $this->redirectToRoute('displaySession', [
            'session' => $userSession->getSession()->getId()
        ]);
    }
}
