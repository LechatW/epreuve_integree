<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Training;
use App\Repository\TrainingRepository;
use App\Repository\UserSessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TrainingController extends AbstractController
{
    /**
     * @Route("/formations", name="displayTrainings")
     */
    public function displayTrainings(TrainingRepository $repository)
    {
        $trainings = $repository->findAll();

        return $this->render('training/trainings.html.twig', [
            'trainings' => $trainings
        ]);
    }

    /**
     * @Route("/formations/{training}", name="displayTraining")
     */
    public function displayTraining(Training $training)
    {
        return $this->render('training/training.html.twig', [
            'training' => $training
        ]);
    }

    /**
     * @Route("/formations/{training}/sessions/{session}", name="displaySession")
     */
    public function displaySession(Training $training, Session $session, UserSessionRepository $userSessionRepository)
    {   
        return $this->render('training/session.html.twig', [
            'training' => $training,
            'session' => $session,
        ]);
    }

    /**
     * @Route("/formations/{training}/calendar", name="displayCalendar")
     */
    public function displayCalendar(Training $training)
    {
        $sessions = $training->getSessions()->toArray();

        foreach ($sessions as $session) {
            $datas[] = [
                "title" => $session->getName(),
                "start" => $session->getStartAt()->format('Y-m-d H:i:s'),
                "end" => $session->getEndAt()->format('Y-m-d H:i:s')
            ];
        }

        $data = json_encode($datas);

        return $this->render('training/calendar.html.twig', [
            'data' => ($data)
        ]);
    }
}
