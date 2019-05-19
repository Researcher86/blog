<?php

namespace Blog\Application\Service;

/**
 * Interface TransactionalSession
 * @package Blog\Application\Service
 */
interface TransactionalSession
{
    /**
     * @param  callable $operation
     * @return mixed
     */
    public function executeAtomically(callable $operation);
}
