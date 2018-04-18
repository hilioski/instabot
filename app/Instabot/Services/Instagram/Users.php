<?php
namespace App\Instabot\Services\Instagram;

class Users extends Base
{
    /**
     * Users constructor.
     * @param string $accessToken
     */
    public function __construct(string $accessToken){
        parent::__construct($accessToken);
    }

    /**
     * @return mixed
     */
    public function getAuthUserInfo(){
        return $this->makeCall('users/self',true);
    }

    /**
     * @return mixed
     */
    public function getUserInfo($userId){
        return $this->makeCall('users/'.$userId,true);
    }

    /**
     * @return mixed
     */
    public function getAuthUserMostRecentPosts(array $params = []){
        return $this->makeCall('users/self/media/recent',true, $params);
    }

    /**
     * @return mixed
     */
    public function getUserMostRecentPosts($userId, array $params = []){
        return $this->makeCall('users/'.$userId.'/media/recent',true, $params);
    }

    /**
     * @return mixed
     */
    public function getAuthUserMostRecentPostsLiked(array $params = []){
        return $this->makeCall('users/self/media/liked',true, $params);
    }

    /**
     * @return mixed
     */
    public function search(array $params){
        return $this->makeCall('users/search',true, $params);
    }
}