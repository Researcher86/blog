<?php

declare(strict_types=1);

namespace Blog\Infrastructure\UI\Web\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\EmptyResponse;

final class BasicAuthMiddleware implements MiddlewareInterface
{
    public const ATTRIBUTE = '_user';

    /**
     * @var array
     */
    private $users;

    public function __construct(array $users)
    {
        $this->users = $users;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $username = $request->getServerParams()['PHP_AUTH_USER'] ?? '';
        $password = $request->getServerParams()['PHP_AUTH_PW'] ?? '';

        $name = $this->checkLoginAndPassword($username, $password);
        if ($name) {
            return $handler->handle(
                $request->withAttribute(self::ATTRIBUTE, $name)
            );
        }

        return new EmptyResponse(
            401,
            ['WWW-Authenticate' => 'Basic realm=Restricted area']
        );
    }

    private function checkLoginAndPassword(
        string $login,
        string $password
    ): ?string {
        foreach ($this->users as $name => $pass) {
            if ($login === $name && $password === $pass) {
                return $name;
            }
        }

        return null;
    }
}
