<?php

namespace ZHC\PhonebookBundle\Controller;

use ZHC\PhonebookBundle\Entity\Number;
use ZHC\PhonebookBundle\Form\NumberType;
use ZHC\PhonebookBundle\Entity\Phonebook;
use ZHC\PhonebookBundle\Repository\NumberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NumberController extends AbstractController
{
    /**
     * @Route("/numeros", name="displayNumbers")
     */
    public function displayNumbers(NumberRepository $repository)
    {
        $numbers = $repository->findAll();

        return $this->render('number/numbers.html.twig', [
            'numbers' => $numbers
        ]);
    }

    /**
     * @Route("/annuaires/{phonebook}/numero/{number}/modification", name="editNumber")
     */
    public function editNumber(Phonebook $phonebook, Number $number, Request $request, EntityManagerInterface $entityManager) 
    {
        $roles = $this->getUser()->getRoles();
        $rolesLength = count($roles);
        $rolesManagement = $phonebook->getRolesManagement();

        for($i=0; $i < $rolesLength; $i++) {
            if(in_array($roles[$i],$rolesManagement) || in_array('ROLE_ADMIN',$roles)) {
                $form = $this->createForm(NumberType::class, $number);
                $form->handleRequest($request);
        
                if($form->isSubmitted() && $form->isValid()) {
        
                    $entityManager->persist($number);
                    $entityManager->flush();
        
                    $this->addFlash("success","La modification a bien été effectuée");
        
                    return $this->redirectToRoute('displayPhonebook', [
                        'phonebook' => $phonebook->getId()
                    ]);
                }
        
                return $this->render('number/editNumber.html.twig',[
                    'form' => $form->createView(),
                ]);
            } else {
                $this->addFlash("error","Vous n'avez pas l'autorisation pour modifier un numéro");
        
                return $this->redirectToRoute('displayPhonebook', [
                    'phonebook' => $phonebook->getId()
                ]);
            }
        }
    }

    /**
     * @Route("/annuaires/{phonebook}/numero/{number}",name="deleteNumber", methods="DEL")
     */
    public function deleteNumber(Phonebook $phonebook, Number $number, Request $request, EntityManagerInterface $entityManager)
    {
        $roles = $this->getUser()->getRoles();
        $rolesLength = count($roles);
        $rolesManagement = $phonebook->getRolesManagement();

        for($i=0; $i < $rolesLength; $i++) {
            if(in_array($roles[$i],$rolesManagement) || in_array('ROLE_ADMIN',$roles)) {
                if($this->isCsrfTokenValid("DEL". $number->getId(),$request->get('_token'))) {

                    $phonebook->removeNumber($number);
                    $entityManager->flush();
                
                    $this->addFlash("success","La suppression a bien été effectuée");
        
                    return $this->redirectToRoute('displayPhonebook', [
                        'phonebook' => $phonebook->getId()
                    ]);
                }
            } else {
                $this->addFlash("error","Vous n'avez pas l'autorisation pour supprimer un numéro");
        
                return $this->redirectToRoute('displayPhonebook', [
                    'phonebook' => $phonebook->getId()
                ]);
            }
        }

    }

    /**
     * @Route("/annuaires/{phonebook}/numero/ajout", name="addNumber")
     */
    public function addNumber(NumberRepository $repository, Phonebook $phonebook, EntityManagerInterface $entityManager)
    {
        $roles = $this->getUser()->getRoles();
        $rolesLength = count($roles);
        $rolesManagement = $phonebook->getRolesManagement();

        for($i=0; $i < $rolesLength; $i++) {
            if(in_array($roles[$i],$rolesManagement) || in_array('ROLE_ADMIN',$roles)) {
                $numbers = $repository->findNotInPhonebook($phonebook->getId());
                
                if($_POST) {
                    if(isset($_POST['number'])) {
                        foreach($_POST['number'] as $id) {
                            $number = $repository->findOneBy([
                                'id' => $id
                            ]);
                            $phonebook->addNumber($number);
                            $entityManager->persist($number);
                        }
                    } 
                    if(!empty($_POST['newNumber']) && !empty($_POST['numberName']) && !empty($_POST['numberType'])) {
                        $newNumber = new Number();

                        $newNumber->setName($_POST['numberName'])
                                  ->setPhoneNumber($_POST['newNumber'])
                                  ->setType($_POST['numberType'])
                                  ->addPhonebook($phonebook)
                        ;
                        $entityManager->persist($newNumber);
                    }
                    
                    $entityManager->flush();
            
                    $this->addFlash("success","L'ajout a bien été effectué");
    
                    return $this->redirectToRoute('displayPhonebook', [
                        'phonebook' => $phonebook->getId()
                    ]);
                }
        
                return $this->render('number/addNumber.html.twig', [
                    'numbers' => $numbers,
                    'phonebook' => $phonebook
                ]);
            } else {
                $this->addFlash("error","Vous n'avez pas l'autorisation pour ajouter un numéro");
        
                return $this->redirectToRoute('displayPhonebook', [
                    'phonebook' => $phonebook->getId()
                ]);
            }
        }
    }
}
