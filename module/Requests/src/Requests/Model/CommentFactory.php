<?php

namespace Requests\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Requests\Model\Comment;

class CommentFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $query = $serviceLocator->get('wrapperQuery')->setEntity('Requests\Entity\Comment');
        return new Comment($query);
    }

}
