<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('/rules', function () {
    $rules = \App\Models\Rule::all();

    foreach ($rules as $rule) {
        echo $rule->id . ' | ' .$rule->action->display_name . ' - ' . $rule->criteria->display_name . ' <br> ';
    }
});

Route::get('/exec/{id}', function ($id) {
    $rule = \App\Models\Rule::find($id);

    $hashtags = \App\Models\Hashtag::all();

    foreach ($hashtags as $hashtag) {
//        $response = (new \App\Instabot\Services\Instagram\Users(session('access_token')))->getUserMostRecentPosts('436006264');
        $response = (new \App\Instabot\Services\Instagram\Likes(session('access_token')))->unlike('1703135532056634158_357615087');
        dd($response);
        foreach ($response['data'] as $post) {
            if($post['user_has_liked'])
                continue;

            // Like current post
            $client1 = new GuzzleHttp\Client();
            $res1 = $client1->request('POST', 'https://api.instagram.com/v1/media/'.$post['id'].'/likes', [
                'form_params' => [
                    'access_token' => session('access_token')
                ]

            ]);

            $response1 = json_decode((string) $res1->getBody(), true);

            dd($response1);
        }
        dd($response);
        echo '<hr>';
    }

});




Route::get('/login', function () {
    return redirect('https://api.instagram.com/oauth/authorize/?client_id='.env('INSTAGRAM_CLIENT_ID').'&redirect_uri='.env('INSTAGRAM_REDIRECT_URL').'&response_type=code&scope=basic+public_content+follower_list+relationships+likes+comments');
});

Route::get('/callback', function () {
    echo 'From insta...';
    $client = new GuzzleHttp\Client();
    $res = $client->request('POST', 'https://api.instagram.com/oauth/access_token', [
        'form_params' => [
            'client_id' => env('INSTAGRAM_CLIENT_ID'),
            'client_secret' => env('INSTAGRAM_CLIENT_SECRET'),
            'grant_type' => 'authorization_code',
            'redirect_uri' => env('INSTAGRAM_REDIRECT_URL'),
            'code' => request('code')
        ]

    ]);

    $response = json_decode((string) $res->getBody(), true);
    dd($response);

    session(['access_token' => $response['access_token']]);

    return redirect('home');
});

Route::get('/home', function () {
    dd(session('access_token'));
});

Route::get('/recent-post', function () {
//    $tag = 'KikoPhotography';
    $tag = 'healthyfood';

    $client = new GuzzleHttp\Client();
    $res = $client->request('GET', 'https://api.instagram.com/v1/tags/'.$tag.'/media/recent?client_id='.env('INSTAGRAM_CLIENT_ID').'&access_token='.session('access_token'));

    $response = json_decode((string) $res->getBody(), true);

    foreach ($response['data'] as $post) {
        echo $post['id'] . ' | ';
    }
    dd($response);
});

Route::get('/like', function () {
    $postId = '1703569596114871323_6963682655';
    $client = new GuzzleHttp\Client();
    $res = $client->request('POST', 'https://api.instagram.com/v1/media/'.$postId.'/likes', [
        'form_params' => [
            'access_token' => session('access_token')
        ]

    ]);

    $response = json_decode((string) $res->getBody(), true);

    dd($response);
});

Route::get('/unlike', function () {
    $postId = '1703569596114871323_6963682655';
    $client = new GuzzleHttp\Client();
    $res = $client->request('DELETE', 'https://api.instagram.com/v1/media/'.$postId.'/likes?access_token='.session('access_token'));

    $response = json_decode((string) $res->getBody(), true);

    dd($response);
});

Route::get('/followed-by', function () {
    $client = new GuzzleHttp\Client();
    $res = $client->request('GET', 'https://api.instagram.com/v1/users/self/followed-by?access_token='.session('access_token'));

    $response = json_decode((string) $res->getBody(), true);

    dd($response);
});

Route::get('/follows', function () {
    $client = new GuzzleHttp\Client();
    $res = $client->request('GET', 'https://api.instagram.com/v1/users/self/follows?access_token='.session('access_token'));

    $response = json_decode((string) $res->getBody(), true);

    dd($response);
});

Route::get('/relation', function () {
    $userid = '6963682655';
    $client = new GuzzleHttp\Client();
    $res = $client->request('GET', 'https://api.instagram.com/v1/users/'.$userid.'/relationship?access_token='.session('access_token'));

    $response = json_decode((string) $res->getBody(), true);

    dd($response);
});

Route::get('/user', function () {
    $userid = '6963682655';
    $client = new GuzzleHttp\Client();
    $res = $client->request('GET', 'https://api.instagram.com/v1/users/'.$userid.'?access_token='.session('access_token'));

    $response = json_decode((string) $res->getBody(), true);

    dd($response);
});

Route::get('/follow', function () {
    $userid = '6963682655';
    $client = new GuzzleHttp\Client();
    $res = $client->request('POST', 'https://api.instagram.com/v1/users/'.$userid.'/relationship', [
        'form_params' => [
            'access_token' => session('access_token'),
            'action' => 'follow'
        ]

    ]);

    $response = json_decode((string) $res->getBody(), true);

    dd($response);
});

Route::get('/unfollow', function () {
    $userid = '6963682655';
    $client = new GuzzleHttp\Client();
    $res = $client->request('POST', 'https://api.instagram.com/v1/users/'.$userid.'/relationship', [
        'form_params' => [
            'access_token' => session('access_token'),
            'action' => 'unfollow'
        ]

    ]);

    $response = json_decode((string) $res->getBody(), true);

    dd($response);
});

Route::get('/comment', function () {
    $userid = '1703569596114871323_6963682655';
    $client = new GuzzleHttp\Client();
    $res = $client->request('POST', 'https://api.instagram.com/v1/media/'.$userid.'/comments', [
        'form_params' => [
            'access_token' => session('access_token'),
            'text' => 'I love your facts! #healthyfood @thehealthyfacts'
        ]

    ]);

    $response = json_decode((string) $res->getBody(), true);

    dd($response);
});



Route::get('/run-job', function () {
    $user = \App\Models\User::where('email', 'djkiko15@gmail.com')->first();

//    \App\Jobs\ProcessUserDesiredRule::dispatch($user);

    (new \App\Instabot\Services\Processes\ProcessUserRule($user))->run();
});