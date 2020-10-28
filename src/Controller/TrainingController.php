<?php

namespace App\Controller;

use App\Entity\Training;
use App\Form\TrainingType;
use App\Repository\TrainingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TrainingController extends AbstractController
{
    /**
     * @Route("/formations", name="displayTrainings")
     */
    public function displayTrainings(TrainingRepository $repository)
    {
        $trainings = $repository->findAll();

        if($trainings) {
            return $this->render('training/trainings.html.twig', [
                'trainings' => $trainings
            ]);
        }

        $this->addFlash("error", "Formations introuvable");

        return $this->redirectToRoute('displayPhonebooks');
    }

    /**
     * @Route("/formations/{training}", name="displayTraining", requirements={"training":"\d+"})
     */
    public function displayTraining(Training $training = null)
    {
        if($training) {
            return $this->render('training/training.html.twig', [
                'training' => $training
            ]);
        }

        $this->addFlash("error", "Formation introuvable");

        return $this->redirectToRoute('displayTrainings');
    }

    /**
     * @Route("/formations/ajout", name="addTraining", methods="GET|POST")
     * @Route("/formations/{training}/edition", name="editTraining", methods="GET|POST", requirements={"training":"\d+"})
     */
    public function editOrAddTraining(Training $training = null, Request $request, EntityManagerInterface $entityManager)
    {
        $isModif = true;

        if(!$training) {
            $training = new Training();
            $isModif = false;
        }

        $form = $this->createForm(TrainingType::class, $training);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $training->setContact($this->getUser());
            $entityManager->persist($training);
            $entityManager->flush();

            if($isModif) {
                $this->addFlash("success","La modification a bien été effectuée");
            } else {
                $this->addFlash("success","L'ajout a bien été effectué");
            }

            return $this->redirectToRoute('displayTrainings');
        }
        
        return $this->render('training/editOrAddTraining.html.twig', [
            'training' => $training,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/formations/{training}/suppression",name="deleteTraining", methods="DEL", requirements={"training":"\d+"})
     */
    public function deleteTraining(Training $training, Request $request, EntityManagerInterface $entityManager)
    {
        if($this->isCsrfTokenValid("DEL". $training->getId(),$request->get('_token'))) {
            $entityManager->remove($training);
            $entityManager->flush();
            
            $this->addFlash("success","La suppression a bien été effectuée");
            
            return $this->redirectToRoute("displayTrainings");
        }

        $this->addFlash("error","Une erreur est survenue lors de la suppression d'une formation");

        return $this->redirectToRoute('displayTrainings');
    }
}
