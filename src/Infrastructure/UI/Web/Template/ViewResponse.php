<?php

namespace Blog\Infrastructure\UI\Web\Template;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ViewResponse implements ResponseInterface
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var array
     */
    private $data;
    /**
     * @var int
     */
    private $status;
    /**
     * @var array
     */
    private $headers;


    /**
     * ViewResponse constructor.
     * @param string $name
     * @param array $data
     * @param int $status
     * @param array $headers
     */
    public function __construct(string $name, array $data = [], int $status = 200, array $headers = [])
    {
        $this->name = $name;
        $this->data = $data;
        $this->status = $status;
        $this->headers = $headers;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function getProtocolVersion()
    {
        // TODO: Implement getProtocolVersion() method.
    }

    public function withProtocolVersion($version)
    {
        // TODO: Implement withProtocolVersion() method.
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function hasHeader($name)
    {
        // TODO: Implement hasHeader() method.
    }

    public function getHeader($name)
    {
        // TODO: Implement getHeader() method.
    }

    public function getHeaderLine($name)
    {
        // TODO: Implement getHeaderLine() method.
    }

    public function withHeader($name, $value)
    {
        // TODO: Implement withHeader() method.
    }

    public function withAddedHeader($name, $value)
    {
        // TODO: Implement withAddedHeader() method.
    }

    public function withoutHeader($name)
    {
        // TODO: Implement withoutHeader() method.
    }

    public function getBody()
    {
        // TODO: Implement getBody() method.
    }

    public function withBody(StreamInterface $body)
    {
        // TODO: Implement withBody() method.
    }

    public function getStatusCode()
    {
        return $this->status;
    }

    public function withStatus($code, $reasonPhrase = '')
    {
        // TODO: Implement withStatus() method.
    }

    public function getReasonPhrase()
    {
        // TODO: Implement getReasonPhrase() method.
    }
}
