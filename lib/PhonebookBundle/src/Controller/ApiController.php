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
use Symfony\Contracts\HttpClient\HttpClientInterface;
use ZHC\PhonebookBundle\Repository\NumberRepository;

class ApiController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/appel/{number}", name="call")
     */
    public function call(Number $number, NumberRepository $numberRepository)
    {
        $callFrom = $numberRepository->findByUserAndType($this->getUser()->getId(), 'internal');
        $callTo = $number->getPhoneNumber();
        $callType = $number->getType();
        $callerId = $this->getUser()->getLogin();
        
        $response = $this->client->request(
            'POST',
            'http://admin:admin@192.168.1.24:8088/ari/channels?endpoint=PJSIP/'.$callFrom->getPhoneNumber().'&extension='.$callTo.'&context='.$callType.'&priority=1&callerId='.$callerId
        );

        if($response->getStatusCode() !== 200) {
            $this->addFlash('error',"Une erreur est survenue lors de l'appel, veuillez réessayer plus tard");
            return $this->redirectToRoute('displayNumbers');
        }

        return $this->redirectToRoute('displayNumbers');
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

                $delete = "\"DELETE FROM Phone;\" \"DELETE FROM Contact;\" \"DELETE FROM Name;\"";
                $insert = "";

                foreach($numbers as $key => $number) {
                    $insert .= "\"INSERT INTO Contact VALUES(".($key+1).");\" \"INSERT INTO Name VALUES(".($key+1).",".($key+1).",0,0,'','','','".$number->getUser()->getFirstName().' '.$number->getUser()->getLastName()."');\" \"INSERT INTO Phone VALUES(".($key+1).",".($key+1).",0,'".$number->getPhoneNumber()."','".$number->getPhoneNumber()."',1,1,1,1,1,NULL,NULL);\" ";
                }
                
                $cmd = "sqlite3 %APPDATA%/Zoiper5/ContactsV2.db \"PRAGMA foreign_keys=OFF;\" \"BEGIN TRANSACTION;\" $delete $insert \"COMMIT;\" \".exit\"";
                shell_exec($cmd);

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
