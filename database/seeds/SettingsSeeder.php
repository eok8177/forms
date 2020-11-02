<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            ['id' => 1, 'key' => 'feedback_email', 'name' => 'Admin email', 'value' => 'sergey.markov@gmail.com'],
            ['id' => 2, 'key' => 'date_format', 'name' => 'Date Format', 'value' => 'dd/mm/yyyy'],
            ['id' => 3, 'key' => 'key_map', 'name' => 'Google MAP key', 'value' => 'AIzaSyDnxGiPdH3lTiOVu98kJxvn3h8Oezlw3w4'],
            ['id' => 4, 'key' => 'form_type_colors', 'name' => 'Form Type Colors', 'value' => '#fff, #f00, #0f0, #00f, #000'],
            ['id' => 5, 'key' => 'from_email', 'name' => 'Default from email', 'value' => 'myrvaw@gmail.com'],
        ]);
    }
}
