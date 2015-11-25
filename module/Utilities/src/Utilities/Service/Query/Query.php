<?php
namespace Utilities\Service\Query;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\Criteria;

class Query
{
    /**
     *
     * @var ObjectManager 
     */
    public $entityManager;
    /**
     *
     * @var Doctrine\Common\Persistence\ObjectRepository 
     */
    public $entityRepository;
    /**
     *
     * @var string 
     */
    public $entityName;
    
    /**
     * 
     * @param ObjectManager $entityManager
     */
    public function __construct(ObjectManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * 
     * @param string $entityName
     */
    public function setEntity($entityName) {
        if(! empty($entityName)){
            $this->entityName = $entityName;
            $this->entityRepository = $this->entityManager->getRepository($entityName);
        }
        return $this;
    }
    
    /**
     * Finds an entity by its primary key / identifier.
     *
     * @param mixed    $id          The identifier.
     *
     * @return object|null The entity instance or NULL if the entity can not be found.
     */
    public function find($entityName, $id)
    {
        return $this->setEntity($entityName)->entityRepository->find($id);
    }

    /**
     * Finds all entities in the repository.
     *
     * @return array The entities.
     */
    public function findAll($entityName)
    {
        return $this->setEntity($entityName)->entityRepository->findAll();
    }

    /**
     * Finds entities by a set of criteria.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return array The objects.
     */
    public function findBy($entityName, array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->setEntity($entityName)->entityRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Finds a single entity by a set of criteria.
     *
     * @param array $criteria
     * @param array|null $orderBy
     *
     * @return object|null The entity instance or NULL if the entity can not be found.
     */
    public function findOneBy($entityName, array $criteria, array $orderBy = null)
    {
        return $this->setEntity($entityName)->entityRepository->findOneBy($criteria, $orderBy);
    }
    
    public function filter($entityName, Criteria $criteria)
    {
        return $this->setEntity($entityName)->entityRepository->matching($criteria);
    }
}