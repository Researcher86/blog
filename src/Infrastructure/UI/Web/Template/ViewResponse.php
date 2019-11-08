<?php

declare(strict_types=1);

namespace Blog\Infrastructure\UI\Web\Template;

use Zend\Diactoros\Response;

final class ViewResponse extends Response
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var array<string, string|int|float|bool|object|array>
     */
    private $data;

    /**
     * ViewResponse constructor.
     *
     * @param string $name View name
     * @param array<string, string|int|float|bool|object|array> $data
     *  Variables for view
     * @param int $status Response status
     * @param array<string, string> $headers Response headers
     */
    public function __construct(
        string $name,
        array $data = [],
        int $status = 200,
        array $headers = []
    ) {
        $this->name = $name;
        $this->data = $data;

        parent::__construct('php://memory', $status, $headers);
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string|null $key
     *
     * @return array<string|int|float|object|array> Variables for view
     */
    public function getData(?string $key = null): array
    {
        /** @var array<string|int|float|object|array> $result */
        $result = $key ? $this->data[$key] : $this->data;
        return $result;
    }
}
