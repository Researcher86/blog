<?php

declare(strict_types=1);

namespace Blog\Infrastructure\Persistence\Doctrine\Fixture;

use Blog\Domain\Model\Post\Post;
use Blog\Domain\Model\Post\PostId;
use Blog\Domain\Model\User\User;
use Blog\Domain\Model\User\UserId;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

final class DataLoader extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 100; $i++) {
            if ($i === 0) {
                $userId = new UserId('11111111-1111-1111-1111-111111111111');
            } else {
                $userId = new UserId();
            }
            $manager->persist(new User(
                $userId,
                $faker->name,
                random_int(18, 100)
            ));

            $this->fillPosts($manager, $faker, $userId);
        }

        $manager->flush();
    }

    private function fillPosts(
        ObjectManager $manager,
        Generator $faker,
        UserId $userId
    ): void {
        for ($i = 0; $i < 10; $i++) {
            if ($i === 0) {
                $postId = new PostId('11111111-1111-1111-1111-111111111111');
            } else {
                $postId = new PostId();
            }

            $post = new Post($postId, $faker->name, $userId);
            $post->addComment($faker->text, $userId);
            $post->addComment($faker->text, $userId);
            $post->addComment($faker->text, $userId);
            $manager->persist($post);
        }
    }
}
