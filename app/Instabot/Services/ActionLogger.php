<?php
namespace App\Instabot\Services;


use Illuminate\Support\Facades\Log;

class ActionLogger
{
    /**
     * @var string
     */
    private $accessToken;

    /**
     * ActionLogger constructor.
     * @param string $accessToken
     */
    public function __construct(string $accessToken){
        $this->accessToken = $accessToken;

        Log::useDailyFiles(storage_path('/logs/instagram_api_logs/'.$accessToken.'.log'));
    }

    /**
     * @param string $entityId -> Post or Profile
     * @param string $action
     */
    public function logAction(string $entityId, string $action){
        Log::info($entityId . '|' . $action);
    }
}