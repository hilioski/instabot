<?php
namespace App\Instabot\Services\Processes;

use App\Instabot\Services\Instagram\Likes;
use App\Instabot\Services\Instagram\Relationships;
use App\Instabot\Services\Instagram\Tags;
use App\Instabot\Services\Instagram\Users;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProcessUserRule
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * ProcessUserRule constructor.
     * @param User $user
     */
    public function __construct(User $user){
        $this->user = $user;
        $this->accessToken = $user->instagram_access_token;
    }

    public function run(){
        $rule = $this->user->rule;

        if($rule->action->name == 'like'){
            switch ($rule->criteria->name){
                case 'by_hashtag':
                    $hashtags = ['healthyfood', 'kikophotography'];

                    $allowedActionPerHashtag = (count($hashtags) <= (int) env('USER_ACTION_PER_JOB')) ? (int) round((int) env('USER_ACTION_PER_JOB') / (int) count($hashtags)) : 1;
                    $actionDone = 0;

                    foreach ($hashtags as $hashtag){
                        $recentPosts = (new Tags($this->accessToken))->getRecentPostsByTag($hashtag)['data'];

                        $actionPerHashtag = 0;
                        foreach ($recentPosts as $post){
                            if($actionPerHashtag == $allowedActionPerHashtag)
                                break;

                            // Like N posts
                            if(! $post['user_has_liked']){
                                (new Likes($this->accessToken))->like($post['id']);
                                $actionDone++;
                                $actionPerHashtag++;
                                Log::info('User: '.$this->user->id.' Rule: like - '.$rule->criteria->name.' executed on:'.Carbon::now()->format('Y-m-d H:i:s').' on post with id: '.$post['id'].' was successfully!');
                            }
                        }
                    }

                    break;
                case 'by_followers':
                    $followers = (new Relationships($this->accessToken))->getAuthUserFollowedBy()['data'];
                    shuffle($followers);

                    $allowedActionPerFollower = (count($followers) <= (int) env('USER_ACTION_PER_JOB')) ? (int) round((int) env('USER_ACTION_PER_JOB') / (int) count($followers)) : 1;
                    $actionDone = 0;
                    foreach ($followers as $follower) {
                        $posts = (new Users($this->accessToken))->getUserMostRecentPosts($follower['id'])['data'];

                        $actionPerFollower = 0;
                        foreach ($posts as $post) {
                            if($actionPerFollower == $allowedActionPerFollower)
                                break;
                            // Like N posts
                            if(! $post['user_has_liked']){
                                (new Likes($this->accessToken))->like($post['id']);
                                $actionDone++;
                                $actionPerFollower++;
                                Log::info('User: '.$this->user->id.' Rule: like - '.$rule->criteria->name.' executed on:'.Carbon::now()->format('Y-m-d H:i:s').' on post with id: '.$post['id'].' was successfully!');
                            }
                        }
                    }
                    break;
                case 'by_followings':
                    $followings = (new Relationships($this->accessToken))->getAuthUserFollows()['data'];
                    shuffle($followings);

                    $allowedActionPerFollowing = (count($followings) <= (int) env('USER_ACTION_PER_JOB')) ? (int) round((int) env('USER_ACTION_PER_JOB') / (int) count($followings)) : 1;
                    $actionDone = 0;
                    foreach ($followings as $following) {
                        $posts = (new Users($this->accessToken))->getUserMostRecentPosts($following['id'])['data'];

                        $actionPerFollowing = 0;
                        foreach ($posts as $post) {
                            if($actionPerFollowing == $allowedActionPerFollowing)
                                break;
                            // Like N posts
                            if(! $post['user_has_liked']){
                                (new Likes($this->accessToken))->like($post['id']);
                                $actionDone++;
                                $actionPerFollowing++;
                                Log::info('User: '.$this->user->id.' Rule: like - '.$rule->criteria->name.' executed on:'.Carbon::now()->format('Y-m-d H:i:s').' on post with id: '.$post['id'].' was successfully!');
                            }
                        }
                    }                    break;
                default:
                    Log::info('User: '.$this->user->id.' Rule: like - '.$rule->criteria->name.' executed on:'.Carbon::now()->format('Y-m-d H:i:s').' was successfully!');
            }
            return true;
        }

        if($rule->action->name == 'follow'){
            switch ($rule->criteria->name){
                case 'by_hashtag':
                    $hashtags = ['healthyfood', 'kikophotography'];

                    $allowedActionPerHashtag = (count($hashtags) <= (int) env('USER_ACTION_PER_JOB')) ? (int) round((int) env('USER_ACTION_PER_JOB') / (int) count($hashtags)) : 1;
                    $actionDone = 0;
                    foreach ($hashtags as $hashtag){
                        $recentPosts = (new Tags($this->accessToken))->getRecentPostsByTag($hashtag)['data'];

                        $actionPerHashtag = 0;
                        foreach ($recentPosts as $post){
                            if($actionPerHashtag == $allowedActionPerHashtag)
                                break;

                            // Follow N users
                            if($post['user']['id']){
                                $relationWithUser = (new Relationships($this->accessToken))->getAuthUserRelationshipWithUser($post['user']['id'])['data'];

                                if($relationWithUser['outgoing_status'] != 'none' || $post['user']['id'] == $this->user->instagram_user_id)
                                    continue;

                                (new Relationships($this->accessToken))->modifyAuthUserRelationshipWithUser($post['user']['id'], 'follow');
                                $actionDone++;
                                $actionPerHashtag++;
                                Log::info('User: '.$this->user->id.' Rule: follow - '.$rule->criteria->name.' executed on:'.Carbon::now()->format('Y-m-d H:i:s').' on user with id: '.$post['user']['id'].' was successfully!');
                            }
                        }
                    }

                    Log::info('User: '.$this->user->id.' Rule: follow - '.$rule->criteria->name.' executed on:'.Carbon::now()->format('Y-m-d H:i:s').' was successfully!');
                    break;
                case 'by_followers_one_way_relation':
                    Log::info('User: '.$this->user->id.' Rule: follow - '.$rule->criteria->name.' executed on:'.Carbon::now()->format('Y-m-d H:i:s').' was successfully!');
                    break;
                default:
                    Log::info('User: '.$this->user->id.' Rule: follow - '.$rule->criteria->name.' executed on:'.Carbon::now()->format('Y-m-d H:i:s').' was successfully!');
            }
            return true;
        }

        if($rule->action->name == 'unfollow'){
            switch ($rule->criteria->name){
                case 'by_followings_one_way_relation':
                    Log::info('User: '.$this->user->id.' Rule: unfollow - '.$rule->criteria->name.' executed on:'.Carbon::now()->format('Y-m-d H:i:s').' was successfully!');
                    break;
                case 'by_followings_two_way_relation':
                    Log::info('User: '.$this->user->id.' Rule: unfollow - '.$rule->criteria->name.' executed on:'.Carbon::now()->format('Y-m-d H:i:s').' was successfully!');
                    break;
                case 'by_followings':
                    Log::info('User: '.$this->user->id.' Rule: unfollow - '.$rule->criteria->name.' executed on:'.Carbon::now()->format('Y-m-d H:i:s').' was successfully!');
                    break;
                default:
                    Log::info('User: '.$this->user->id.' Rule: unfollow - '.$rule->criteria->name.' executed on:'.Carbon::now()->format('Y-m-d H:i:s').' was successfully!');
            }
            return true;
        }

        if($rule->action->name == 'comment'){
            switch ($rule->criteria->name){
                case 'by_hashtag':
                    Log::info('User: '.$this->user->id.' Rule: comment - '.$rule->criteria->name.' executed on:'.Carbon::now()->format('Y-m-d H:i:s').' was successfully!');
                    break;
                case 'by_followers':
                    Log::info('User: '.$this->user->id.' Rule: comment - '.$rule->criteria->name.' executed on:'.Carbon::now()->format('Y-m-d H:i:s').' was successfully!');
                    break;
                case 'by_followings':
                    Log::info('User: '.$this->user->id.' Rule: comment - '.$rule->criteria->name.' executed on:'.Carbon::now()->format('Y-m-d H:i:s').' was successfully!');
                    break;
                default:
                    Log::info('User: '.$this->user->id.' Rule: comment - '.$rule->criteria->name.' executed on:'.Carbon::now()->format('Y-m-d H:i:s').' was successfully!');
            }
            return true;
        }

        return false;
    }
}