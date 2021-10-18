<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{


    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $userArray = [
            ["firstName" => "Mathias", "lastName" => "Gilles", "password" => "fb132fce5", "email" => "mathiasgilles136@gmail.com", "address" => "65 avenue de Poissy", "postalCode" => 78260, "city" => "Achères", "wallet" => 0.00, "phone" => "0612687977", "roles" => ["ROLE_ADMIN"]],
            ["firstName" => "Diego", "lastName" => "Gilles", "password" => "fb132fce5", "email" => "diego.gilles@gmail.com", "address" => "154 rue Lafayette", "postalCode" => 75011, "city" => "Paris", "wallet" => 0.00, "phone" => "0612687977", "roles" => ["ROLE_USER"]]
        ];

        foreach ($userArray as $user) {
            $new = new User();
            $new->setRoles($user['roles'])
                ->setPostalCode($user['postalCode'])
                ->setCity($user['city'])
                ->setAddress($user['address'])
                ->setEmail($user['email'])
                ->setLastName($user['lastName'])
                ->setFirstName($user['firstName'])
                ->setPhone($user['phone'])
                ->setWallet($user['wallet'])
                ->setPassword($this->passwordHasher->hashPassword($new, $user['password']));
            $manager->persist($new);
        }
        $manager->flush();
    }
}
