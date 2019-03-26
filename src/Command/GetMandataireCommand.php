<?php

namespace App\Command;

use App\Entity\Annonces;
use App\Entity\Mandataire;
use App\Entity\MandatairesTest;
use App\Repository\MandatairesTestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GetMandataireCommand extends Command
{
    protected static $defaultName = 'app:get-mandataire';


    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setDescription('Extract the mandataire')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        // Get all annonces
        $annonces = $this->em->getRepository(Annonces::class)->findAll();


        /** @var Annonces $annonce */
        foreach ($annonces as $annonce){

            $commentaire = $annonce->getCommentaires();


            $results = preg_split('/[,|;]+/',$commentaire);

            foreach ($results as $result){

                if ($this->findMandataire($result, $annonce, 'administrateur judiciaire')) continue;
                if ($this->findMandataire($result, $annonce, 'administrateur')) continue;
                if ($this->findMandataire($result, $annonce, 'mandataire judiciaire avec mission de surveillance')) continue;
                if ($this->findMandataire($result, $annonce, 'mandataire judiciaire')) continue;
                if ($this->findMandataire($result, $annonce, 'liquidateur')) continue;
            }

            $this->em->flush();


        }

        $io->success('Les mandataires ont été bien exportés et enregistrés dans la base de données');
    }


    private function findMandataire($result, $annonce, $fonction){

        $startPos = strpos($result,$fonction);
        if ($startPos){
            $startPos += strlen($fonction);
            $mandataire = new Mandataire();
            $mandataire->setFonction($fonction);
            $mandataire->setAnnonces($annonce);
            $name = substr($result,$startPos);
            // clean name
            $name = preg_replace('/[^A-Za-z0-9\ -]/', '', $name);
            $mandataire->setNom($name);
            if ($name != '' && strlen($name) > 1 &&
                !strpos($name,'www') &&
                strpos($name, 'au') !== 0 && strpos($name, 'au') !== 1 &&
                strpos($name, 'avec') !== 0 && strpos($name, 'avec') !== 1 ){

                // Get a the closest mandataire from database
                $mandataireId = $this->em->getRepository(MandatairesTest::class)->findByMandataireName($name);
                // If found
                if ($mandataireId){
                    /** @var MandatairesTest $mandataireTest */
                    $mandataireTest = $this->em->getRepository(MandatairesTest::class)->findOneBy(['id' => $mandataireId]);
                    $mandataire->setMandataireTrouve($mandataireTest);
                }


                $this->em->persist($mandataire);
                return true;
            }
        }
        return false;
    }

}
