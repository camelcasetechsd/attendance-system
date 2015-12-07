<?php

namespace Requests\Model;

/**
 * Comment Model
 * 
 * Handles Comment Entity related business
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author mohamed ramadan
 * 
 * @property Utilities\Service\Query\Query $query
 * 
 * @package requests
 * @subpackage model
 */
class Comment {

    /**
     *
     * @var Utilities\Service\Query\Query 
     */
    protected $query;

    /**
     * Set needed properties
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param Utilities\Service\Query\Query $query
     */
    public function __construct($query) {
        $this->query = $query;
    }

    /**
     * Create new comment
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param Requests\Entity\Comment $commentObj
     * @param array $data
     * @param int $userId
     * @param int $requestId
     * @param string $requestType
     */
    public function create($commentObj, $data, $userId, $requestId, $requestType) {
        $user = $this->query->find('Users\Entity\User', $userId);
        $data['user'] = $user;
        $data['created'] = "now";
        $data['request_type'] = $requestType;
        $data['request_id'] = $requestId;
        $this->query->setEntity('Requests\Entity\Comment')->save($commentObj, $data);
    }

    /**
     * List request comments
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param int $userId
     * @param int $requestId
     * @param string $requestType
     * @return array comments for request
     */
    public function listRequestComments($userId, $requestId, $requestType) {
        $comments = $this->query->findBy('Requests\Entity\Comment', array(
            'request_id' => $requestId,
            'request_type' => $requestType
        ));

        foreach ($comments as $comment) {
            $comment->created = date_format($comment->created, 'Y-M-D H:i:s');
            $commentCreator = $comment->user->id;
            if ($userId === $commentCreator) {
                $comment->iscreator = TRUE;
            } else {
                $comment->iscreator = FALSE;
            }
            $comment->user = $comment->user->name;
        }
        return $comments;
    }

}
