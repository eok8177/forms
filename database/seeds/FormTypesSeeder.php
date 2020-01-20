<?php

use Illuminate\Database\Seeder;

class FormTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('form_types')->insert([
			['id' => 1, 'name' => 'General'],
			['id' => 2, 'name' => 'Analytical'],
			['id' => 3, 'name' => 'Evaluation'],
			['id' => 4, 'name' => 'Exp of Interest']
		]);
	}
	
}
