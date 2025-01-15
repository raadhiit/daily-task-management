<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {       
        $user = User::create([
            'name'          => 'Syafitri Ramadani',
            'id_mch'        => 'ADM',
            'sub'           => 'MCH',
            'NPK'           => '17092289',
            'password'      =>  Hash::make('123'),
            'level'         => 1
        ]);
    }
}
