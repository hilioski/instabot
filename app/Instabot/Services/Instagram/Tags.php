<?php
namespace App\Instabot\Services\Instagram;

class Tags extends Base
{
    /**
     * Tags constructor.
     * @param string $accessToken
     */
    public function __construct(string $accessToken){
        parent::__construct($accessToken);
    }

    /**
     * @param $tag
     * @return mixed
     */
    public function getTagInfo($tag){
        $tag = is_int(strpos($tag, '#')) ? substr($tag, 1, strlen($tag)-1) : $tag;

        return $this->makeCall('tags/'.$tag,true);
    }

    /**
     * @param $tag
     * @return mixed
     */
    public function getRecentPostsByTag($tag, array $params = []){
        $tag = is_int(strpos($tag, '#')) ? substr($tag, 1, strlen($tag)-1) : $tag;

        return $this->makeCall('tags/'.$tag.'/media/recent',true, $params);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function search(array $params){
        return $this->makeCall('tags/search',true, $params);
    }
}