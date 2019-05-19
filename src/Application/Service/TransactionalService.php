<?php


namespace Blog\Application\Service;


class TransactionalService implements ApplicationService
{
    /**
     * @var ApplicationService
     */
    private $service;
    /**
     * @var TransactionalSession
     */
    private $session;

    /**
     * TransactionalService constructor.
     * @param ApplicationService $service
     * @param TransactionalSession $session
     */
    public function __construct(ApplicationService $service, TransactionalSession $session)
    {
        $this->service = $service;
        $this->session = $session;
    }

    public function execute($request)
    {
        $operation = function () use ($request) {
            return $this->service->execute($request);
        };

        return $this->session->executeAtomically($operation);
    }
}