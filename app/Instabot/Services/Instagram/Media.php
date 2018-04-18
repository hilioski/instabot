<?php
namespace App\Instabot\Services\Instagram;

class Media extends Base
{
    /**
     * Media constructor.
     * @param string $accessToken
     */
    public function __construct(string $accessToken){
        parent::__construct($accessToken);
    }

    /**
     * @return mixed
     */
    public function getMediaInfo($mediaId){
        return $this->makeCall('media/'.$mediaId,true);
    }

    /**
     * @return mixed
     */
    public function getMediaInfoByShortcode($shortcode){
        return $this->makeCall('media/shortcode/'.$shortcode,true);
    }

    /**
     * @return mixed
     */
    public function search(array $params){
        return $this->makeCall('media/search',true, $params);
    }
}