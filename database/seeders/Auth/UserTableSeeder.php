<?php

namespace Database\Seeders\Auth;

use App\Events\Backend\UserCreated;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $users = [
            [
                'id' => 1,
                'username' => '100001',
                'name' => 'administrator',
                'email' => 'administrator@email.com',
                'password' => 'secret',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'username' => '100002',
                'name' => 'operational',
                'email' => 'operational@email.com',
                'password' => 'secret',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'username' => '100003',
                'name' => 'sales',
                'email' => 'sales@email.com',
                'password' => 'secret',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        foreach ($users as $user_data) {
            $user = User::create($user_data);

            event(new UserCreated($user));
        }
    }
}
