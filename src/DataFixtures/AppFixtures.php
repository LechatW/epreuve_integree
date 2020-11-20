<?php

namespace App\DataFixtures;

use App\Entity\Session;
use App\Entity\Training;
use ZHC\PhonebookBundle\Entity\Number;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\UserSession;
use DateTime;
use ZHC\PhonebookBundle\Entity\Phonebook;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Time;

class AppFixtures extends Fixture
{
    private $encoder;

      public function __construct(UserPasswordEncoderInterface $encoder)
      {
            $this->encoder = $encoder;
      }

      public function load(ObjectManager $manager)
      {
            $faker = Factory::create('fr_FR');

            /**
             * Phonebooks
             */
            $phonebook1 = new Phonebook();
            $phonebook1->setName('Caserne Mons')
                       ->setRolesManagement(['ROLE_ANNUAIRE_MONS'])
                       ->setRolesVisibility(['ROLE_RH','ROLE_COMPTABILITE'])
            ;
            $manager->persist($phonebook1);

            $phonebook2 = new Phonebook();
            $phonebook2->setName('Comptabilité')
                        ->setRolesManagement(['ROLE_COMPTABILITE'])
                        ->setRolesVisibility(['ROLE_USER'])
            ;
            $manager->persist($phonebook2);

            $phonebook3 = new Phonebook();
            $phonebook3->setName('RH')
                        ->setRolesManagement(['ROLE_RH'])
                        ->setRolesVisibility(['ROLE_RH'])
            ;
            $manager->persist($phonebook3);
            

            /**
             * Users
             */
            $user1 = new User();
            $user1->setLogin('user1')
                  ->setPassword($this->encoder->encodePassword($user1, 'user1'))
                  ->setRoles(['ROLE_ADMIN','ROLE_USER'])
                  ->setFirstName($faker->firstName())
                  ->setLastName($faker->lastName())
            ;
            $manager->persist($user1);

            $user2 = new User();
            $user2->setLogin('user2')
                  ->setPassword($this->encoder->encodePassword($user2, 'user2'))
                  ->setRoles(['ROLE_RH','ROLE_USER'])
                  ->setFirstName($faker->firstName())
                  ->setLastName($faker->lastName())
            ;
            $manager->persist($user2);

            $user3 = new User();
            $user3->setLogin('user3')
                  ->setPassword($this->encoder->encodePassword($user3, 'user3'))
                  ->setRoles(['ROLE_ANNUAIRE_MONS','ROLE_USER'])
                  ->setFirstName($faker->firstName())
                  ->setLastName($faker->lastName())
            ;
            $manager->persist($user3);

            $user4 = new User();
            $user4->setLogin('user4')
                  ->setPassword($this->encoder->encodePassword($user4, 'user4'))
                  ->setRoles(['ROLE_COMPTABILITE','ROLE_USER'])
                  ->setFirstName($faker->firstName())
                  ->setLastName($faker->lastName())
            ;
            $manager->persist($user4);

             /**
             * Numbers
             */
            $number1 = new Number();
            $number1->setName('Caserne Mons')
                    ->setPhoneNumber($faker->phoneNumber())
                    ->setType('external')
                    ->addPhonebook($phonebook1)
                    ->setUser($user1)
            ;
            $manager->persist($number1);

            $number2 = new Number();
            $number2->setName('Secrétariat bis')
                    ->setPhoneNumber($faker->phoneNumber())
                    ->setType('external')
                    ->addPhonebook($phonebook1)
                    ->setUser($user2)
            ;
            $manager->persist($number2);

            $number3 = new Number();
            $number3->setName('Police')
                    ->setPhoneNumber($faker->phoneNumber())
                    ->setType('external')
                    ->addPhonebook($phonebook2)
                    ->setUser($user3)
            ;
            $manager->persist($number3);

            $number4 = new Number();
            $number4->setName('Ambulance')
                    ->setPhoneNumber($faker->phoneNumber())
                    ->setType('external')
                    ->addPhonebook($phonebook2)
                    ->addPhonebook($phonebook1)
                    ->setUser($user4)
            ;
            $manager->persist($number4);

            $number5 = new Number();
            $number5->setName($user1->getFirstName(). ' '. $user1->getLastName())
                    ->setPhoneNumber($faker->phoneNumber)
                    ->setType('external')
                    ->setUser($user1)
            ;
            $manager->persist($number5);

            $number6 = new Number();
            $number6->setName($user1->getFirstName(). ' '. $user1->getLastName())
                    ->setPhoneNumber('200')
                    ->setType('internal')
                    ->setUser($user1)
            ;
            $manager->persist($number6);

            $number7 = new Number();
            $number7->setName($user2->getFirstName(). ' '. $user2->getLastName())
                    ->setPhoneNumber('201')
                    ->setType('internal')
                    ->setUser($user2)
            ;
            $manager->persist($number7);

            $number8 = new Number();
            $number8->setName($user3->getFirstName(). ' '. $user3->getLastName())
                    ->setPhoneNumber('202')
                    ->setType('internal')
                    ->setUser($user3)
            ;
            $manager->persist($number8);

            $number9 = new Number();
            $number9->setName($user4->getFirstName(). ' '. $user4->getLastName())
                    ->setPhoneNumber('203')
                    ->setType('internal')
                    ->setUser($user4)
            ;
            $manager->persist($number9);

            /**
             * Trainings
             */
            $training1 = new Training();
            $training1->setName('Ambulance')
                      ->setTarget('Ambulanciers')
                      ->setContact($user1)
            ;
            $manager->persist($training1);

            $training2 = new Training();
            $training2->setName('Caméra')
                      ->setTarget('Pompiers')
                      ->setContact($user1)
            ;
            $manager->persist($training2);

            $training3 = new Training();
            $training3->setName('Police')
                      ->setTarget('Policiers')
                      ->setContact($user2)
            ;
            $manager->persist($training3);

            /**
             * Sessions
             */
            $session1 = new Session();
            $session1->setName('Ambulance T0-01')
                     ->setStartAt(new DateTime('2020-11-14 08:00'))
                     ->setEndAt(new DateTime('2020-11-14 16:00'))
                     ->setRegistrationStartAt(new DateTime('2020-10-01'))
                     ->setRegistrationEndAt(new DateTime('2020-11-05'))
                     ->setLocation('Mons')
                     ->setMaxRegistration(10)
                     ->setTraining($training1)
            ;
            $manager->persist($session1);

            $session2 = new Session();
            $session2->setName('Ambulance T0-02')
                     ->setStartAt(new DateTime('2020-11-16 08:00'))
                     ->setEndAt(new DateTime('2020-11-16 16:00'))
                     ->setRegistrationStartAt(new DateTime('2020-10-02'))
                     ->setRegistrationEndAt(new DateTime('2020-11-06'))
                     ->setLocation('Mons')
                     ->setMaxRegistration(10)
                     ->setTraining($training1)
            ;
            $manager->persist($session2);

            $session3 = new Session();
            $session3->setName('Caméra T0-01')
                     ->setStartAt(new DateTime('2020-12-01 08:00'))
                     ->setEndAt(new DateTime('2020-12-01 16:00'))
                     ->setRegistrationStartAt(new DateTime('2020-11-01'))
                     ->setRegistrationEndAt(new DateTime('2020-11-09'))
                     ->setLocation('La louvière')
                     ->setMaxRegistration(8)
                     ->setTraining($training2)
            ;
            $manager->persist($session3);

            /**
             * UserSessions
             */
            $userSession1 = new UserSession();
            $userSession1->setUser($user1)
                         ->setSession($session1)
                         ->setStatus('En cours')
            ;
            $manager->persist($userSession1);
            
            $manager->flush();

            $userSession1 = new UserSession();
            $userSession1->setUser($user2)
                         ->setSession($session1)
                         ->setStatus('Validé')
            ;
            $manager->persist($userSession1);
            
            $manager->flush();

            $userSession1 = new UserSession();
            $userSession1->setUser($user3)
                         ->setSession($session1)
                         ->setStatus('Annulé')
            ;
            $manager->persist($userSession1);
            
            $manager->flush();
      }
}
