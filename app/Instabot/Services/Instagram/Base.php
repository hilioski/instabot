<?php
namespace App\Instabot\Services\Instagram;

use App\Exceptions\InstagramException;
use GuzzleHttp\Client;

class Base
{

    /**
     * @var Client
     */
    protected $client;
    /**
     * @var string
     */
    protected $accessToken;
    /**
     * @var string
     */
    protected $clientId;

    /**
     * InstagramApi constructor.
     * @param Client $client
     */
    public function __construct(string $accessToken){
        $this->accessToken = $accessToken;
        $this->client = new Client();
        $this->clientId = env('INSTAGRAM_CLIENT_ID');
    }

    protected function makeCall($function, $auth = false, $params = null, $method = 'GET'){
        if (!$auth) {
            // if the call doesn't requires authentication
            $authMethod = '?client_id=' . $this->clientId;
        } else {
            // if the call needs an authenticated user
            if (!isset($this->accessToken)) {
                throw new InstagramException("Error: _makeCall() | $function - This method requires an authenticated users access token.");
            }
            $authMethod = '?access_token=' . $this->accessToken;
        }

        $paramString = null;

        if (isset($params) && is_array($params)) {
            $paramString = '&' . http_build_query($params);
        }


        switch ($method) {
            case 'GET':
                $response = $this->client->request('GET', env('INSTAGRAM_API_BASE_URL').$function.$authMethod.$paramString);
                break;
            case 'POST':
                $response = $this->client->request('POST', env('INSTAGRAM_API_BASE_URL').$function.$authMethod, [
                    'form_params' => $params
                ]);
                break;
            case 'DELETE':
                $response = $this->client->request('DELETE', env('INSTAGRAM_API_BASE_URL').$function.$authMethod, [
                    'form_params' => $params
                ]);
                break;
            default:
                throw new InstagramException("Error: _makeCall() | $method - This method is not supported.");
        }

        // Decode JSON
        $response = json_decode((string) $response->getBody(), true);

        return $response;
    }
}