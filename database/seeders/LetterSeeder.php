<?php

namespace Database\Seeders;

use App\Models\Letter;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Letter::create([
            'title' => 'Letter #01',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse tempus et est eget convallis. Nullam eu tempor est. Nullam congue nulla eu eros fermentum, dictum varius neque varius. Integer euismod augue sit amet justo aliquet, a dapibus nibh volutpat. Duis sodales, orci sit amet pretium rutrum, leo ligula vestibulum ante',
            'date_to_send' => Carbon::now()->format('Y-m-d'),
            'received' => 1,
            'read' => 0,
            'recipient_email' => 'johndoe@loremipsum.com',
            'user_id' => '1',
            'visibility_id' => 1
        ]);

        Letter::create([
            'title' => 'Letter #02',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse tempus et est eget convallis. Nullam eu tempor est. Nullam congue nulla eu eros fermentum, dictum varius neque varius. Integer euismod augue sit amet justo aliquet, a dapibus nibh volutpat. Duis sodales, orci sit amet pretium rutrum, leo ligula vestibulum ante',
            'date_to_send' => Carbon::now()->format('Y-m-d'),
            'received' => 1,
            'read' => 0,
            'recipient_email' => 'johndoe@loremipsum.com',
            'user_id' => '1',
            'visibility_id' => 1
        ]);
    }
}
