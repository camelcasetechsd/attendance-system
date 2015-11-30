<?php
namespace Utilities\Service\Query;

use Zend\Paginator\Adapter\AdapterInterface;
use Doctrine\Common\Collections\Criteria;

class PaginatorAdapter implements AdapterInterface
{
    protected $query;
    
    public function __construct( $query)
    {
        if(empty($query->entityName)){
            throw new \Exception('query entityName property shoudl be set');
        }
        $this->query = $query;
    }
    
    public function count($mode = 'COUNT_NORMAL') {
        return $this->query->filter(/*$entityName =*/ null, /*$criteria =*/ false, /*$countFlag =*/ true);
    }

    public function getItems($offset, $itemCountPerPage) {
        $criteria = new Criteria(/*$expression =*/ null, /*$orderings =*/ null, /*$firstResult =*/ $offset, /*$maxResults =*/ $itemCountPerPage);
        return  $this->query->filter(/*$entityName =*/ null, $criteria); //($pageNumber-1) for zero based count
    }

}