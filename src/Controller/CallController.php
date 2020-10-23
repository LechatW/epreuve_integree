<?php

namespace App\Controller;

use App\Entity\Call;
use App\Entity\Number;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CallController extends AbstractController
{
    /**
     * @Route("/appel/{number}", name="call")
     */
    public function call(EntityManagerInterface $entityManager, Number $number)
    {
        $currentUser = $this->getUser();

        if($currentUser && $currentUser->getId() !== $number->getUser()->getId()) {
            $call = new Call();
            $call->setDate(new DateTime('now'))
                 ->setUserIn($this->getUser())
                 ->setUserOut($number->getUser())
            ;
    
            $entityManager->persist($call);
            $entityManager->flush();

            $this->addFlash("success","Appel effectué");

            return $this->redirectToRoute('displayNumbers');
        } else {
            $this->addFlash("error", "Erreur lors de l'appel, veuillez réessayer plus tard");

            return $this->redirectToRoute('displayNumbers');
        }
    }
}
