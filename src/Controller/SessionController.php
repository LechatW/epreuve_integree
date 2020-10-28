<?php

namespace App\Controller;

use App\Entity\Training;
use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use App\Repository\TrainingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    /**
     * @Route("/formations/{training}/calendar", name="displayCalendar", requirements={"training":"\d+"})
     */
    public function displayCalendar(Training $training = null, SessionRepository $sessionRepository)
    {
        $sessions = $sessionRepository->findByTrainingOrderByDate($training);
        
        if($sessions) {
            $defaultDate = $sessions[0]->getStartAt()->format('Y-m-d');

            foreach ($sessions as $session) {
                $datas[] = [
                    "title" => $session->getName(),
                    "start" => $session->getStartAt()->format('Y-m-d H:i:s'),
                    "end" => $session->getEndAt()->format('Y-m-d H:i:s')
                ];
            }
    
            $data = json_encode($datas);
    
            return $this->render('session/calendar.html.twig', [
                'data' => $data,
                'defaultDate' => $defaultDate
            ]);
        }

        $this->addFlash("error","Sessions introuvable");

        return $this->redirectToRoute('displayTraining', [
            'training' => $training->getId()
        ]);
    }

    /**
     * @Route("/sessions/ajout", name="addSession", methods="GET|POST")
     * @Route("/sessions/{session}/edition", name="editSession", methods="GET|POST", requirements={"session":"\d+"})
     */
    public function editOrAddSession(Session $session = null, TrainingRepository $trainingRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $isModif = true;

        if(!$session) {
            $session = new Session();
            $isModif = false;
        }

        $training = $trainingRepository->findOneBy([
            'id' => $request->get('training')
        ]);

        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $session->setTraining($training);
-           $entityManager->persist($session);
            $entityManager->flush();

            if($isModif) {
                $this->addFlash("success","La modification a bien été effectuée");
            } else {
                $this->addFlash("success","L'ajout a bien été effectué");
            }

            return $this->redirectToRoute('displayTraining', [
                'training' => $session->getTraining()->getId()
            ]);
        }
        
        return $this->render('session/editOrAddSession.html.twig', [
            'session' => $session,
            'training' => $training,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/sessions/{session}", name="displaySession")
     */
    public function displaySession(Session $session = null)
    {   
        if($session) {
            return $this->render('session/session.html.twig', [
                'session' => $session
            ]);
        }

        $this->addFlash("error", "Session introuvable");

        return $this->redirectToRoute('displayTrainings');
    }

    /**
     * @Route("/sessions/{session}/suppression", name="deleteSession", methods="DEL", requirements={"session":"\d+"})
     */
    public function deleteTraining(Session $session, Request $request, EntityManagerInterface $entityManager)
    {
        if($this->isCsrfTokenValid("DEL". $session->getId(),$request->get('_token'))) {
            $entityManager->remove($session);
            $entityManager->flush();
            
            $this->addFlash("success","La suppression a bien été effectuée");
            
            return $this->redirectToRoute('displayTraining', [
                'training' => $session->getTraining()->getId()
            ]);
        }

        $this->addFlash("error","Une erreur est survenue lors de la suppression d'une session");

        return $this->redirectToRoute('displayTraining', [
            'training' => $session->getTraining()->getId()
        ]);
    }

    /**
     * @Route("/sessions/{session}/duplication", name="duplicateSession", requirements={"session":"\d+"})
     */
    public function duplicateSession(Session $session = null, EntityManagerInterface $entityManager)
    {
        if($session) {
            $newSession = new Session();

            $newSession->setName($session->getName(). "-Clone")
            ->setStartAt($session->getStartAt())
            ->setEndAt($session->getEndAt())
            ->setRegistrationStartAt($session->getRegistrationStartAt())
            ->setRegistrationEndAt($session->getRegistrationEndAt())
            ->setLocation($session->getLocation())
            ->setMaxRegistration($session->getMaxRegistration())
            ->setTraining($session->getTraining())
            ;

            $entityManager->persist($newSession);
            $entityManager->flush();

            $this->addFlash("success","La duplication a bien été effectuée");
                
            return $this->redirectToRoute('displayTraining', [
                'training' => $session->getTraining()->getId()
            ]);
        }

        $this->addFlash("error", "La duplication n'a pas pu être effectuée");

        return $this->redirectToRoute('displayTrainings');
    }
}
