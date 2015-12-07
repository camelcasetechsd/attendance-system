<?php

namespace Requests\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Requests\Model\Comment;

/**
 * Comment Factory
 * 
 * Prepare Comment service factory
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @package requests
 * @subpackage model
 */
class CommentFactory implements FactoryInterface {

    /**
     * Prepare Comment service
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @uses Comment
     * 
     * @access public
     * @param ServiceLocatorInterface $serviceLocator
     * @return Comment
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $query = $serviceLocator->get('wrapperQuery')->setEntity('Requests\Entity\Comment');
        return new Comment($query);
    }

}
