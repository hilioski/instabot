<?php
namespace App\Instabot\Services\Instagram;

class Relationships extends Base
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
    public function getAuthUserFollows(){
        return $this->makeCall('users/self/follows',true);
    }

    /**
     * @return mixed
     */
    public function getAuthUserFollowedBy(){
        return $this->makeCall('users/self/followed-by',true);
    }

    /**
     * @return mixed
     */
    public function getAuthUserRequestedBy(){
        return $this->makeCall('users/self/requested-by',true);
    }

    /**
     * @return mixed
     */
    public function getAuthUserRelationshipWithUser($userId){
        return $this->makeCall('users/'.$userId.'/relationship',true);
    }

    /**
     * @return mixed
     */
    public function modifyAuthUserRelationshipWithUser($userId, $action){
        return $this->makeCall('users/'.$userId.'/relationship',true, ['action'=>$action], 'POST');
    }
}