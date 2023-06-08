<?php

namespace Database\Seeders;

use App\Models\Credentials;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CredentialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Credentials::create([
            'password' => Hash::Make('123456'), 
            'email' => 'teste@teste.com', 
            'user_id' => 1, 
            'google_id' => 1]
        );
    }
}
