<?php

use Illuminate\Database\Seeder;
use App\Models\Criteria;

class CriteriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $criterias = [
            [
                'name' => 'by_hashtag',
                'display_name' => 'By Hashtag',
                'is_active' => true
            ],
            [
                'name' => 'by_followers',
                'display_name' => 'By Followers',
                'is_active' => true
            ],
            [
                'name' => 'by_followings',
                'display_name' => 'By Followings',
                'is_active' => true
            ],
            [
                'name' => 'by_followings_one_way_relation',
                'display_name' => 'By Followings but not getting back',
                'is_active' => true
            ],
            [
                'name' => 'by_followings_two_way_relation',
                'display_name' => 'By Followings and getting back',
                'is_active' => true
            ],
            [
                'name' => 'by_followers_one_way_relation',
                'display_name' => 'By Followers but not getting back',
                'is_active' => true
            ],
            [
                'name' => 'by_followers_two_way_relation',
                'display_name' => 'By Followers and getting back',
                'is_active' => true
            ]
        ];

        foreach ($criterias as $criteria) {
            if(! Criteria::where($criteria)->count()){
                Criteria::create($criteria);
            }
        }
    }
}
