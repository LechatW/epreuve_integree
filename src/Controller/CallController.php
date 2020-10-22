<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CallController extends AbstractController
{
    /**
     * @Route("/appel/{number}", name="call")
     */
    public function call()
    {
        return $this->render('call/index.html.twig', [
            'controller_name' => 'CallController',
        ]);
    }
}
