<?php

namespace App\DataFixtures;

use App\Entity\Todo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i=0; $i <50 ; $i++) { 
            $todo = new Todo();
            $todo->setTitle('todo_' . $i);
            $manager->persist($todo);
        }

        $manager->flush();
    }
}
