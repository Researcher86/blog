<?php

namespace Blog\Infrastructure\Persistence\Doctrine\Fixture;

use Blog\Domain\Model\Post\Post;
use Blog\Domain\Model\Post\PostId;
use Blog\Domain\Model\User\User;
use Blog\Domain\Model\User\UserId;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class DataLoader extends AbstractFixture
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 100; $i++) {
            if ($i == 0) {
                $userId = new UserId('11111111-1111-1111-1111-111111111111');
            } else {
                $userId = new UserId();
            }
            $manager->persist(new User($userId, $faker->name, random_int(18, 100)));

            for ($j = 0; $j < 10; $j++) {
                $manager->persist(new Post(new PostId(), $faker->name, $userId));
            }
        }


        $manager->flush();
    }
}