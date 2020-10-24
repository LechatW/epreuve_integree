<?php

namespace ZHC\PhonebookBundle\Command;


use ZHC\PhonebookBundle\Controller\ScriptController;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ScriptCommand extends Command
{
    protected static $defaultName = 'app:script';  

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Call to the script route')
            ->setHelp('This command retrieve datas from the numbers API')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->writeln([
            '==========================',
            '. . . Loading script . . .',
            '=========================='
        ]);

        if($this->load()) {
            $io->success('Numbers correctly loaded !');
        } else {
            $io->error('An error occured, try again please');
        }

        return 0;
    }

    private function load() {
        $isLoaded = false;

        $em = $this->entityManager;

        try {
            ScriptController::retrieveDatas($em);
            $isLoaded = true;
        } catch(Exception $e) {
            $isLoaded = false;
        }
        
        return $isLoaded;
    }
}
