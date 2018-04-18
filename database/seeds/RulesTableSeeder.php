<?php

use Illuminate\Database\Seeder;
use App\Models\Rule;
use App\Models\Criteria;
use App\Models\Action;

class RulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rules = [
            // like - by_hashtag
            [
                'action_id' => Action::where('name', 'like')->first()->id,
                'criteria_id' => Criteria::where('name', 'by_hashtag')->first()->id
            ],
            // like - by_followers
            [
                'action_id' => Action::where('name', 'like')->first()->id,
                'criteria_id' => Criteria::where('name', 'by_followers')->first()->id
            ],
            // like - by_followings
            [
                'action_id' => Action::where('name', 'like')->first()->id,
                'criteria_id' => Criteria::where('name', 'by_followings')->first()->id
            ],

            // follow - by_hashtag
            [
                'action_id' => Action::where('name', 'follow')->first()->id,
                'criteria_id' => Criteria::where('name', 'by_hashtag')->first()->id
            ],
            // follow - by_followers_one_way_relation
            [
                'action_id' => Action::where('name', 'follow')->first()->id,
                'criteria_id' => Criteria::where('name', 'by_followers_one_way_relation')->first()->id
            ],

            // unfollow - by_followings_one_way_relation
            [
                'action_id' => Action::where('name', 'unfollow')->first()->id,
                'criteria_id' => Criteria::where('name', 'by_followings_one_way_relation')->first()->id
            ],
            // unfollow - by_followings_two_way_relation
            [
                'action_id' => Action::where('name', 'unfollow')->first()->id,
                'criteria_id' => Criteria::where('name', 'by_followings_two_way_relation')->first()->id
            ],
            // unfollow - by_followings
            [
                'action_id' => Action::where('name', 'unfollow')->first()->id,
                'criteria_id' => Criteria::where('name', 'by_followings')->first()->id
            ],

            // comment - by_hashtag
            [
                'action_id' => Action::where('name', 'comment')->first()->id,
                'criteria_id' => Criteria::where('name', 'by_hashtag')->first()->id
            ],
            // comment - by_followers
            [
                'action_id' => Action::where('name', 'comment')->first()->id,
                'criteria_id' => Criteria::where('name', 'by_followers')->first()->id
            ],
            // comment - by_followings
            [
                'action_id' => Action::where('name', 'comment')->first()->id,
                'criteria_id' => Criteria::where('name', 'by_followings')->first()->id
            ],
        ];

        foreach ($rules as $rule) {
            if(! Rule::where($rule)->count()){
                Rule::create($rule);
            }
        }
    }
}
