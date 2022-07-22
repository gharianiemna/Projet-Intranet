<?php

namespace App\DataFixtures;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixture extends Fixture
{
    private $userPasswordEncoder;

    public function __construct( UserPasswordEncoderInterface $userPasswordEncoder){
        $this->userPasswordEncoder = $userPasswordEncoder;
    }
    public function load(ObjectManager $manager): void
    {
    $userList=[
        [   "FirstName"=> "Admin",
            "LastName"=> "Talan",
            "email"=>"admin@talan.com",
            "Password"=> "admin123",
            "roles"=> ["ROLE_ADMIN"],
        ],
        [   "FirstName"=> "Emna",
            "LastName"=> "Ghariani",
            "email"=>"emna@talan.com",
            "Password"=> "emna123",
            "roles"=>  ["ROLE_USER"],
        ],
        [   "FirstName"=> "Habib",
            "LastName"=> "Hajjem",
            "email"=>"habib@talan.com",
            "Password"=> "habib123",
            "roles"=>   ["ROLE_USER"],
        ],
        [   "FirstName"=>"Samar",
            "LastName"=> "Cherni",
            "email"=>"samar@talan.com",
            "Password"=> "samar123",
            "roles"=>  ["ROLE_USER"],
        ],
        [   "FirstName"=> "Kenza",
            "LastName"=> "Daghrir",
            "email"=>"kenza@talan.com",
            "Password"=> "kenza123",
            "roles"=>  ["ROLE_USER"],
        ],
        [   "FirstName"=> "Rania",
            "LastName"=> " Amairi",
            "email"=>'rania@talan.com',
            "Password"=> "rania123",
            "roles"=>  ["ROLE_USER"],
        ],
    ];
        foreach ($userList as $users){
            $user =new User();
            $user->setFirstname( $users["FirstName"])
                ->setLastname( $users["LastName"])
                ->setEmail( $users["email"])
                ->setPassword($this->userPasswordEncoder->encodePassword($user,$users["Password"]))
                ->setRoles( $users["roles"]);    
            $manager->persist($user); 
        }
        $manager->flush();
        }
    public function getDependencies()
    {
            return array(
              UserFixture::class,
            );
    }
    }

