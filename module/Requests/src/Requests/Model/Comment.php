<?php

namespace Requests\Model;

class Comment {

    protected $query;

    public function __construct($query) {
        $this->query = $query;
    }

    public function create($commentObj, $data, $userId, $requestId, $requestType) {
        $user = $this->query->find('Users\Entity\User', $userId);
        $data['user'] = $user;
        $data['created'] = "now";
        $data['request_type'] = $requestType;
        $data['request_id'] = $requestId;
        $this->query->setEntity('Requests\Entity\Comment')->save($commentObj, $data);
    }

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
