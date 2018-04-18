<?php
namespace App\Instabot\Services\Instagram;

class Locations extends Base
{
    /**
     * Location constructor.
     * @param string $accessToken
     */
    public function __construct(string $accessToken){
        parent::__construct($accessToken);
    }

    /**
     * @return mixed
     */
    public function getLocationInfo($locationId){
        return $this->makeCall('locations/'.$locationId,true);
    }

    /**
     * @return mixed
     */
    public function getRecentPostsByLocation($locationId){
        return $this->makeCall('locations/'.$locationId.'/media/recent',true);
    }

    /**
     * @return mixed
     */
    public function search(array $params){
        return $this->makeCall('locations/search',true, $params);
    }
}