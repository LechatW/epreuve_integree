<?php

namespace ZHC\PhonebookBundle\Controller;

use ZHC\PhonebookBundle\Entity\Call;
use ZHC\PhonebookBundle\Entity\Number;
use ZHC\PhonebookBundle\Entity\Phone;
use ZHC\PhonebookBundle\Entity\Phonebook;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
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

    /**
     * @Route("/export/{phonebook}", name="export")
     */
    public function export(Phonebook $phonebook, EntityManagerInterface $entityManager) 
    {
        $roles = $this->getUser()->getRoles();
        $rolesLength = count($roles);
        $rolesManagement = $phonebook->getRolesManagement();
        
        for($i=0; $i < $rolesLength; $i++) {
            if(in_array($roles[$i],$rolesManagement) || in_array('ROLE_ADMIN',$roles)) {
                $numbers = $phonebook->getNumbers();

                $phone = new Phone();

                foreach ($numbers as $number) {
                    $phone->addNumber($number);
                }

                $phone->setUser($this->getUser());

                $entityManager->persist($phone);
                $entityManager->flush();

                $this->addFlash("success","L'export a bien été effectué");
    
                return $this->redirectToRoute('displayPhonebook', [
                    'phonebook' => $phonebook->getId()
                ]);
            } else {
                $this->addFlash("error","Vous n'avez pas l'autorisation pour exporter les numéros");
        
                return $this->redirectToRoute('displayPhonebook', [
                    'phonebook' => $phonebook->getId()
                ]);
            }
        }
    }
}
