<?php

namespace ZHC\PhonebookBundle\Controller;

use ZHC\PhonebookBundle\Entity\Phonebook;
use ZHC\PhonebookBundle\Form\PhonebookType;
use ZHC\PhonebookBundle\Repository\PhonebookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PhonebookController extends AbstractController
{
     /**
     * @Route("/annuaires", name="displayPhonebooks")
     */
    public function displayPhonebooks(PhonebookRepository $repository)
    {        
        $phonebooks = $repository->findAll();

        return $this->render('phonebook/phonebooks.html.twig', [
            'phonebooks' => $phonebooks
        ]);
    }

    /**
     * @Route("/annuaires/{phonebook}", name="displayPhonebook")
     */
    public function displayPhonebook(Phonebook $phonebook)
    {
        $roles = $this->getUser()->getRoles();
        $rolesLength = count($roles);
        $rolesVisibility = $phonebook->getRolesVisibility();
        $rolesManagement = $phonebook->getRolesManagement();

        for($i=0; $i<$rolesLength; $i++) {
            if(in_array($roles[$i],$rolesVisibility) || in_array($roles[$i],$rolesManagement) || 
                in_array('ROLE_USER',$rolesVisibility) || in_array('ROLE_ADMIN',$roles)) {
                $numbers = $phonebook->getNumbers();

                return $this->render('phonebook/phonebook.html.twig', [
                    'phonebook' => $phonebook,
                    'numbers' => $numbers
                ]);
            } else {
                return $this->redirectToRoute('displayPhonebooks');
            }
        }
    }

    /**
     * @Route("/ajout", name="addPhonebook")
     */
    public function addPhonebook(Request $request, EntityManagerInterface $entityManager)
    {
        $phonebook = new Phonebook();

        $form = $this->createForm(PhonebookType::class,$phonebook);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($phonebook);
            $entityManager->flush();

            $this->addFlash("success","L'ajout a bien été effectué");

            return $this->redirectToRoute('displayPhonebooks');
        }
        
        return $this->render('phonebook/addPhonebook.html.twig', [
            'phonebook' => $phonebook,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/annuaires/{phonebook}/suppression",name="deletePhonebook", methods="DEL")
     */
    public function deletePhonebook(Phonebook $phonebook, Request $request, EntityManagerInterface $entityManager)
    {
        if($this->isCsrfTokenValid("DEL". $phonebook->getId(),$request->get('_token'))) {
            $entityManager->remove($phonebook);
            $entityManager->flush();
            
            $this->addFlash("success","La suppression a bien été effectuée");
            
            return $this->redirectToRoute("displayPhonebooks");
        }

        $this->addFlash("error","Une erreur est survenue lors de la suppression d'un annuaire");

        return $this->redirectToRoute('displayPhonebooks');
    }
}
