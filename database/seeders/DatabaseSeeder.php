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
            'name' => "Admin",
            'email' => 'thuanncoi2002@gmail.com',
            'roles'=>1,
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
        DB::table('categories')->insert([
           [
            'name' => "Shirt",
           ],
          [ 'name' => "Pants",],
          [ 'name' => "Dress",],
        ]);
        DB::table('colors')->insert([
            [
             'name' => "Yellow",
             'image'=> "uploads/hgypO9B7Ola3m2Ke0g0XGxUXlaElimgRMzfqozxr.jpg"
            ],
           [ 'name' => "Red",
           'image'=> "uploads/T0j4OjJfYEa5nDYuMYLaAZM1BOD9AZOjslLERkjX.jpg.jpg"
            ],
           [ 'name' => "Black",
           'image'=> "uploads/VWpCEhDgDUVwnkEEWAHK75orxzUEWbva2gJ6SZyA.jpg.jpg.jpg"
            ],
         ]);
         DB::table('sizes')->insert([
            [
             'name' => "S",
            ],
           [ 'name' => "M",],
           [ 'name' => "L",],
         ]);
    }
}
