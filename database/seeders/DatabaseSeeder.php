<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        DB::table('users')->insert([
            'name' => "Poly",
            'email' => 'thuanncoi2002@gmail.com',

            'password' => Hash::make('123456'),
        ]);
        $dataProducts = [
            [
                "name" => "gucci",
                "price" =>"10",
                "description"=>"Test description",
            ],
            [
                "name" => "chanel",
                "price" =>"100",
                "description"=>"Test description",
            ],
        ];
        DB::table('products')->insert($dataProducts);
    }
}
