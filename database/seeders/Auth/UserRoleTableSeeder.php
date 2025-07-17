<?php

namespace Database\Seeders\Auth;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

/**
 * Class UserRoleTableSeeder.
 */
class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        User::findOrFail(1)->assignRole('administrator');
        User::findOrFail(2)->assignRole('operational');
        User::findOrFail(3)->assignRole('sales');

        Artisan::call('cache:clear');
    }
}
