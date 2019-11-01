<?php

use Aura\Router\Map;
use Blog\Infrastructure\UI\Web\Handler\AboutHandler;
use Blog\Infrastructure\UI\Web\Handler\User\GetAllUsersHandler;
use Blog\Infrastructure\UI\Web\Handler\IndexHandler;
use Blog\Infrastructure\UI\Web\Handler\Post\GetPosts;
use Blog\Infrastructure\UI\Web\Handler\Post\GetPostsByUser;
use Blog\Infrastructure\UI\Web\Handler\ProfileHandler;
use Blog\Infrastructure\UI\Web\Handler\ShowHandler;

return function (Map $map) {
    $map->get('home', '/', IndexHandler::class);
    $map->get('show', '/show/{id}', ShowHandler::class)->tokens(['id' => '\d+']);

    $map->get('users', '/users', GetAllUsersHandler::class);
    $map->get('user-posts', '/{userId}/posts', GetPostsByUser::class)->tokens(['userId' => '.+']);
    $map->get('all-posts', '/posts', GetPosts::class);
    $map->get('about', '/about', AboutHandler::class);
    $map->get('profile', '/profile', ProfileHandler::class);
};
