<?php

namespace Database\Seeders;

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

        \App\Models\App::create([
            'name' => 'ANTRIAN APP',
            'institution' => 'SN CODE TECH',
            'logo' => '/images/cQKEOogy5HvNuXmBS6W4FAKCet59TpYc4s9U0DG9.png',
            'description' => 'Panti, Pasaman 082285012905',
            'computer_name' => '',
            'printer_name' => '',
            'video' => '/video/yuGvLApjkx0ltiAKwX02kg4J9E3mbsPT3vVN9ggb.mp4',
            'banner' => '/images/uhbY4YPwtrniAd4SfTrs5xlho7DiDlI42AVacTzq.png',
            'developer' => 'Fahmi Hermandito, S. Kom',
            'use_printer' => true,
            'audio_online' => false,
        ]);
    }
}
