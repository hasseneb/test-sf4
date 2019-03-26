<?php

namespace App\Repository;

use App\Entity\MandatairesTest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MandatairesTest|null find($id, $lockMode = null, $lockVersion = null)
 * @method MandatairesTest|null findOneBy(array $criteria, array $orderBy = null)
 * @method MandatairesTest[]    findAll()
 * @method MandatairesTest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MandatairesTestRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MandatairesTest::class);
    }



    public function findByMandataireName($value)
    {

        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT id FROM test_sf_4.mandataires_test WHERE MATCH (`identity`) AGAINST ('" . $value . "')";
        $stmt = $conn->executeQuery($sql)->fetch();


        return $stmt;
    }



}
