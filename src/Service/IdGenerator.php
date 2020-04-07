<?php

namespace App\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\TransactionRequiredException;
use Exception;

class IdGenerator extends AbstractIdGenerator
{
    /**
     * @param EntityManager $em
     * @param object|null $entity
     *
     * @return mixed
     *
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     * @throws Exception
     */
    public function generate(EntityManager $em, $entity)
    {
        $entityName = get_class($entity);

        while (true) {
            $id = bin2hex(random_bytes(4));

            $item = $em->find($entityName, $id);

            if (!$item) {
                return $id;
            }
        }

        throw new Exception('Could not generate unique id');
    }
}