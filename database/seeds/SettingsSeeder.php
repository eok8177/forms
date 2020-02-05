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
            ['id' => 1, 'key' => 'admin_email', 'name' => 'Admin email', 'value' => 'sergey.markov@gmail.com'],
        ]);
    }
}
