<?php


namespace Blog\Infrastructure\Application\Service;


use Blog\Application\Service\TransactionalSession;
use Blog\Infrastructure\Persistence\Doctrine\EntityManagerFactory;
use Doctrine\ORM\ORMException;
use Throwable;

class DoctrineSession implements TransactionalSession
{
    /**
     * @var EntityManagerFactory
     */
    private $entityManagerFactory;

    /**
     * DoctrineSession constructor.
     * @param EntityManagerFactory $entityManagerFactory
     */
    public function __construct(EntityManagerFactory $entityManagerFactory)
    {
        $this->entityManagerFactory = $entityManagerFactory;
    }

    /**
     * @param callable $operation
     * @return mixed
     * @throws ORMException
     * @throws Throwable
     */
    public function executeAtomically(callable $operation)
    {
        return $this->entityManagerFactory->getEm()->transactional($operation);
    }
}