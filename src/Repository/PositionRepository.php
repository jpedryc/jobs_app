<?php

namespace App\Repository;

use App\Entity\Position;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @method Position|null find($id, $lockMode = null, $lockVersion = null)
 * @method Position|null findOneBy(array $criteria, array $orderBy = null)
 * @method Position[]    findAll()
 * @method Position[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PositionRepository extends ServiceEntityRepository
{
    private $client;

    public function __construct(ManagerRegistry $registry, HttpClientInterface $client)
    {
        parent::__construct($registry, Position::class);

        $this->client = $client;
    }

    public function githubFindPhpPaginated(?int $page = 1)
    {
        $response = $this->client->request(
            'GET',
            'https://jobs.github.com/positions.json?description=php&page='.$page
        );

        if ($response->getStatusCode() === 200) {
            $content = $response->getContent();

            $serializer = new Serializer(
                [ new GetSetMethodNormalizer, new ArrayDenormalizer ],
                [ new JsonEncoder ]
            );

            $positions = $serializer->deserialize($content, Position::class . '[]', 'json');

            return $positions;
        }

        return null;
    }

    public function remotiveFindPhp()
    {
        $response = $this->client->request(
            'GET',
            'https://remotive.io/api/remote-jobs?category=software-dev&search=php'
        );

        if ($response->getStatusCode() === 200) {
            $content = $response->getContent();

            $serializer = new Serializer(
                [ new GetSetMethodNormalizer, new ArrayDenormalizer ],
                [ new JsonEncoder ]
            );

            $positions = $serializer->deserialize($content, Position::class . '[]', 'json');

            return $positions;
        }

        return null;
    }

    // /**
    //  * @return Position[] Returns an array of Position objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Position
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
