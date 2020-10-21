<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="login")
     */
    public function login(AuthenticationUtils $util){

        return $this->render('security/connection.html.twig',[
            'lastUserName' => $util->getLastUsername(),
            'error' => $util->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/deconnexion", name="logout")
     */
    public function logout(){}
}
