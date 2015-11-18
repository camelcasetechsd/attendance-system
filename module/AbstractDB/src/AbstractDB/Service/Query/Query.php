<?php
namespace AbstractDB\Service\Query;

use Doctrine\ORM\EntityManager;

class Query
{
    /**
     *
     * @var EntityManager 
     */
    protected $entityManager;
    /**
     *
     * @var string 
     */
    protected $entityName;
    
    /**
     * 
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }
    
    /**
     * 
     * @param string $entityName
     */
    public function setEntity($entityName) {
        $this->entityName = $entityName;
        $this->entityRepository = $this->entityManager->getRepository($entityName);
        return $this;
    }
    
    /**
     * Finds an entity by its primary key / identifier.
     *
     * @param mixed    $id          The identifier.
     *
     * @return object|null The entity instance or NULL if the entity can not be found.
     */
    public function find($id)
    {
        return $this->entityRepository->find($id);
    }

    /**
     * Finds all entities in the repository.
     *
     * @return array The entities.
     */
    public function findAll()
    {
        return $this->entityRepository->findAll();
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
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->entityRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Finds a single entity by a set of criteria.
     *
     * @param array $criteria
     * @param array|null $orderBy
     *
     * @return object|null The entity instance or NULL if the entity can not be found.
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->entityRepository->findOneBy($criteria, $orderBy);
    }
}