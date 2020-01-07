<?php

use Illuminate\Database\Seeder;

class FormGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('form_groups')->insert([
			['id' => 1, 'name' => 'Outreach'],
			['id' => 2, 'name' => 'Grants'],
			['id' => 3, 'name' => 'Recruitment'],
			['id' => 4, 'name' => 'Subscriptions']
		]);
    }
}
