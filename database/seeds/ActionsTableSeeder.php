<?php

use Illuminate\Database\Seeder;
use App\Models\Action;

class ActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actions = [
            [
                'name' => 'like',
                'display_name' => 'Like',
                'is_active' => true
            ],
            [
                'name' => 'unlike',
                'display_name' => 'Unlike',
                'is_active' => true
            ],
            [
                'name' => 'follow',
                'display_name' => 'Follow',
                'is_active' => true
            ],
            [
                'name' => 'unfollow',
                'display_name' => 'Unfollow',
                'is_active' => true
            ],
            [
                'name' => 'comment',
                'display_name' => 'Comment',
                'is_active' => true
            ]
        ];

        foreach ($actions as $action) {
            if(! Action::where($action)->count()){
                Action::create($action);
            }
        }
    }
}
