<?php
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::truncate();
        User::create([
            'email'             => 'admin@admin.com',
            'password'          => Hash::make('adminadmin'),
            'name'              => 'andres',
            'last_name'         => 'leal',
            'state'             => '1',
            'type'              => '1',
            'rol_idrol'         => '1',
            'company_idcompany' => '1',
            'id'                => '1039679695',
        ]);
    }
}
