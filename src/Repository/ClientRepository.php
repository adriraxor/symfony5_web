<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof Client) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }


    /**
     * Retourne tous les clients pour l'API
     * @return int|mixed|string
     */
    public function findAllClientsAPI(){
        return $this->createQueryBuilder('c')
            ->select('c.email', 'c.pseudo', 'c.roles', 'c.numTel', 'c.nom', 'c.prenom', 'c.country', 'c.photo_profil', 'c.style_couleur_profil')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return int|mixed|string
     * Retourne le nombre de clients inscrits
     */
    public function findNbClientInscritsAPI()
    {
        return $this->createQueryBuilder('c')
            ->select('count(c) AS nb_client')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return int|mixed|string
     */
    public function findClientAPI(){
        return $this->createQueryBuilder('c')
            ->select('c.email', 'c.password')
            ->getQuery()
            ->getResult();
    }
}
