<?php

namespace Blog\Infrastructure\Persistence\Doctrine\Fixture;

use Blog\Domain\Model\User\User;
use Blog\Domain\Model\User\UserId;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class UserDataLoader extends AbstractFixture
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $manager->persist(new User(new UserId(), $faker->name, random_int(18, 100)));
        }


        $manager->flush();
    }
}