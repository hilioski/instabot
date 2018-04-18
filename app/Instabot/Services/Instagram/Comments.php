<?php
namespace App\Instabot\Services\Instagram;

class Comments extends Base
{
    /**
     * Relationships constructor.
     * @param string $accessToken
     */
    public function __construct(string $accessToken){
        parent::__construct($accessToken);
    }

    /**
     * @return mixed
     */
    public function getRecentComments($postId){
        return $this->makeCall('media/'.$postId.'/comments',true);
    }

    /**
     * @return mixed
     */
    public function addComment($postId, $text){
        return $this->makeCall('media/'.$postId.'/comments',true, ['text'=>$text], 'POST');
    }

    /**
     * @return mixed
     */
    public function removeComment($postId, $commentId){
        return $this->makeCall('media/'.$postId.'/comments/'.$commentId,true, [], 'DELETE');
    }
}