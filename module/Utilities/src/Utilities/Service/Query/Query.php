<?php

namespace Utilities\Service\Query;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\Criteria;

/**
 * Query
 * 
 * Handles database queries related business
 * Wrapping commonly used database queries
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @property ObjectManager $entityManager
 * @property Doctrine\Common\Persistence\ObjectRepository $entityRepository
 * @property string $entityName
 * 
 * @package utilities
 * @subpackage query
 */
class Query {

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
     * Set needed properties
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param ObjectManager $entityManager
     */
    public function __construct(ObjectManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * Set entity that is to-be-queried
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $entityName
     * @return \Utilities\Service\Query\Query
     */
    public function setEntity($entityName) {
        if (!empty($entityName)) {
            $this->entityName = $entityName;
            $this->entityRepository = $this->entityManager->getRepository($entityName);
        }
        return $this;
    }

    /**
     * Finds an entity by its primary key / identifier.
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $entityName
     * @param mixed $id The identifier.
     *
     * @return mixed object|null The entity instance or NULL if the entity can not be found.
     */
    public function find($entityName, $id) {
        return $this->setEntity($entityName)->entityRepository->find($id);
    }

    /**
     * Finds all entities in the repository.
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $entityName
     * @return array The entities.
     */
    public function findAll($entityName) {
        return $this->setEntity($entityName)->entityRepository->findAll();
    }

    /**
     * Finds entities by a set of criteria.
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $entityName
     * @param array  $criteria
     * @param array  $orderBy ,default is null
     * @param int    $limit ,default is null
     * @param int    $offset ,default is null
     *
     * @return array The objects.
     */
    public function findBy($entityName, array $criteria, array $orderBy = null, $limit = null, $offset = null) {
        return $this->setEntity($entityName)->entityRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Finds a single entity by a set of criteria.
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $entityName
     * @param array $criteria
     * @param array $orderBy ,default is null
     *
     * @return mixed object|null The entity instance or NULL if the entity can not be found.
     */
    public function findOneBy($entityName, array $criteria, array $orderBy = null) {
        return $this->setEntity($entityName)->entityRepository->findOneBy($criteria, $orderBy);
    }

    /**
     * Filter entities by a set of criteria.
     * Only count of entities can be retrieved
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @uses Criteria
     * 
     * @param string $entityName
     * @param mixed $criteria Criteria instance ,default is bool false
     * @param bool $countFlag ,default is bool false
     * @return type
     */
    public function filter($entityName, $criteria = false, $countFlag = false) {
        if (!$criteria instanceof Criteria) {
            $criteria = new Criteria();
        }
        $return = $this->setEntity($entityName)->entityRepository->matching($criteria);
        if ($countFlag === true) {
            $return = (int) $return->count();
        }
        return $return;
    }

    /**
     * Save entity in database
     * If entity's association hold id not actual object,
     * Then find that object to set the corresponding property with it
     * If data is passed to method, then if exchangeArray method exists in entity,
     * It will be called with the passed data as a parameter
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param mixed $entity entity object to be persisted
     * @param array $data ,default is empty array
     */
    public function save($entity, $data = array()) {
        // if association hold id not actual object, 
        // then find that object to set the corresponding property with it
        $classMetadata = $this->entityManager->getClassMetadata($this->entityName);
        $associationNames = $classMetadata->getAssociationNames();
        foreach ($associationNames as $associationName) {
            if (isset($data[$associationName])) {
                $currentValue = $data[$associationName];
            } else {
                $currentValue = $entity->$associationName;
            }
            if (!is_object($currentValue) && is_numeric($currentValue)) {
                $targetClass = $classMetadata->getAssociationTargetClass($associationName);
                $currentValue = $this->find($targetClass, $currentValue);
                if (isset($data[$associationName])) {
                    $data[$associationName] = $currentValue;
                } else {
                    $entity->$associationName = $currentValue;
                }
            }
        }

        if (!empty($data) && method_exists($entity, 'exchangeArray')) {
            $entity->exchangeArray($data);
        }
        $this->entityManager->persist($entity);
        $this->entityManager->flush($entity);
    }

    /**
     * Remove entity from database
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param mixed $entity entity object to be removed
     */
    public function remove($entity) {
        $this->entityManager->remove($entity);
        $this->entityManager->flush($entity);
    }

}
