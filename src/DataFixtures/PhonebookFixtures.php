<?php

namespace App\DataFixtures;

use App\Entity\Number;
use App\Entity\Phonebook;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PhonebookFixtures extends Fixture
{
        public function load(ObjectManager $manager)
        {
                $phonebook1 = new Phonebook();
                $phonebook1->setName('Caserne Mons')
                                ->setRolesManagement(['ROLE_ANNUAIRE_MONS'])
                                ->setRolesVisibility(['ROLE_RH','ROLE_COMPTABILITE']);
                $manager->persist($phonebook1);

                $phonebook2 = new Phonebook();
                $phonebook2->setName('Comptabilité')
                                ->setRolesManagement(['ROLE_COMPTABILITE'])
                                ->setRolesVisibility(['ROLE_USER']);
                $manager->persist($phonebook2);

                $phonebook3 = new Phonebook();
                $phonebook3->setName('RH')
                                ->setRolesManagement(['ROLE_RH'])
                                ->setRolesVisibility(['ROLE_RH'])
                ;
                $manager->persist($phonebook3);

                /*$phonebooks = [$phonebook1,$phonebook2,$phonebook3];
                $faker = Factory::create('fr_FR');
                foreach($phonebooks as $phonebook) {
                        $random = rand(15,25);
                        for($i = 0; $i <= $random; $i++) {
                                $number = new Number();
                                $number->setPhoneNumber($faker->phoneNumber)
                                        ->addPhonebook($faker->randomElement($phonebooks))
                                ;
                                $manager->persist($number);    
                        }
                }*/

                $number1 = new Number();
                $number1->setName('Caserne Mons')
                        ->setPhoneNumber('065/12.36.32')
                        ->addPhonebook($phonebook1);
                $manager->persist($number1);

                $number2 = new Number();
                $number2->setName('Secrétariat bis')
                        ->setPhoneNumber('066/42.36.32')
                        ->addPhonebook($phonebook1);
                $manager->persist($number2);

                $number3 = new Number();
                $number3->setName('Police')
                        ->setPhoneNumber('067/55.36.32')
                        ->addPhonebook($phonebook2);
                $manager->persist($number3);

                $number4 = new Number();
                $number4->setName('Ambulance')
                        ->setPhoneNumber('068/69.48.32')
                        ->addPhonebook($phonebook2)
                        ->addPhonebook($phonebook1);
                $manager->persist($number4);

                $manager->flush();
        }
}