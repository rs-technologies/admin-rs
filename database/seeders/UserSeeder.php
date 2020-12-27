<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::factory([
            'email'=>"prajapati_sujan1@hotmail.com",
            "name"=>"Sujan Prajapati Maharjan",
            "password"=>Hash::make("Nep@l123")
        ],1)->create();
    }
}
