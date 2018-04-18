<?php

use Illuminate\Database\Seeder;
use App\Models\Hashtag;

class HashtagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hastags = [
            [
                'hashtag' => '#healthyfood'
            ],
            [
                'hashtag' => '#vegetarian'
            ],
            [
                'hashtag' => '#vegan'
            ]
        ];

        foreach ($hastags as $hastag){
            if(! Hashtag::where($hastag)->count()){
                Hashtag::create($hastag);
            }
        }
    }
}
