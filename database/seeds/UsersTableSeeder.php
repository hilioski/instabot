<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'rule_id'                   => '1',
                'email'                     => 'djkiko15@gmail.com',
                'password'                  => 'Test123!',
                'instagram_user_id'         => '357615087',
                'instagram_access_token'    => '357615087.ec67c2f.19e93f3871f74cb1980020004e218103',
                'instagram_username'        => 'hilioski',
                'instagram_profile_picture' => 'https://scontent.cdninstagram.com/vp/ca199f8d7fcbee3c539077266e5ca1ad/5B1DCA29/t51.2885-19/s150x150/17934320_726800680834549_2521628797594238976_a.jpg',
                'instagram_full_name'       => 'Hristian Ilioski',
                'instagram_bio'             => '💻 Web developer
                                                📱Samsung fanatic (Currently used: Galaxy S8)
                                                🎥 Amateur photographer',
                'instagram_website'         => '',
                'instagram_is_business'     => false,
            ],
        ];

        foreach ($users as $user) {
            if (! User::where('email', $user['email'])->count()) {
                User::create($user);
            }
        }
    }
}
