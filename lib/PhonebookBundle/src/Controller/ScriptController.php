<?php

namespace ZHC\PhonebookBundle\Controller;

use ZHC\PhonebookBundle\Entity\Number;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;

class ScriptController extends AbstractController
{
    /**
     * @Route("/script", name="script")
     */
    public static function retrieveDatas(EntityManagerInterface $entityManager)
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET','http://localhost:3000/numbers');
        $contents = $response->toArray();

        foreach($contents as $content) {
            $number = new Number();

            $number->setName($content['name'])
                   ->setPhoneNumber($content['phone_number'])
                   ->setType('external')
            ;

            $entityManager->persist($number);
            $entityManager->flush();
        }
    }
}
