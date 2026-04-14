<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user') -> insert([
            ['nome' => 'Luiz', 'email' => 'luiz@gmail.com', 'senha' => '12345678'],
            ['nome' => 'Pedro', 'email' => 'pedro@gmail.com', 'senha' => '12345678'],
            ['nome' => 'André', 'email' => 'andre@gmail.com', 'senha' => '12345678'],
            ['nome' => 'Júlia', 'email' => 'julia@gmail.com', 'senha' => '12345678'],
            ['nome' => 'Kelly', 'email' => 'Kelly@gmail.com', 'senha' => '12345678'],
            
        ]);
    }
}
