<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'email' => 'ali@vvverb.com',
            'mobile' => '09396776244',
            'password' => bcrypt('qweasdfa'),
            'status' => 1,
        ]);

        $admin->saveMetadata('name', 'Ali Jamalzadeh');
        $admin->saveMetadata('locale', 'fa');

        $admin->roles()->sync([1]);
    }
}
