<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use \App\Entity\Client;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ClientFixtures extends Fixture
{

    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder){
        $this->userPasswordEncoder = $userPasswordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $userAdri = new Client();
        $userAdri->setEmail("figueres.adrien@gmail.com");
        $userAdri->setPassword($this->userPasswordEncoder->encodePassword($userAdri, "bersek66"));
        $userAdri->setNumTel("06-38-31-96-76");
        $userAdri->setPseudo("Adriraxor");
        $userAdri->setPrenom("Adrien");
        $userAdri->setNom("FIGUERES");
        $userAdri->setRoles(array("ROLE_ADMIN"));

        $manager->persist($userAdri);
        $manager->flush();

        $manager->flush();
    }
}
