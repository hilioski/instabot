<?php
namespace App\Instabot\Services\Instagram;

class Likes extends Base
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
    public function getRecentLikes($postId){
        return $this->makeCall('media/'.$postId.'/likes',true);
    }

    /**
     * @return mixed
     */
    public function like($postId){
        return $this->makeCall('media/'.$postId.'/likes',true, [], 'POST');
    }

    /**
     * @return mixed
     */
    public function unlike($postId){
        return $this->makeCall('media/'.$postId.'/likes/',true, [], 'DELETE');
    }
}