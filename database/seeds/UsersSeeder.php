<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1, 
                'login' => 'eok8177', 
                'email' => 'eok8177@gmail.com', 
                'first_name' => 'Evg', 
                'last_name' => 'Ko', 
                'email_verified_at' => '2020-01-14', 
                'password' => '$2y$10$IFbDa664JJ/czBAK2KyuFOE8pJ1n.EJ/qCRJ3UkzaDV9SBv.Re5rK',
                'role' => 'admin'
            ],
            [
                'id' => 2,
                'login' => 'sergey', 
                'email' => 'sergey.markov@gmail.com', 
                'first_name' => 'Sergey', 
                'last_name' => 'Markov', 
                'email_verified_at' => '2020-01-14', 
                'password' => '$2y$10$WNrT.NBwWvQ0moZ7wgkniOdPLZkoCajkJFFikcQ5Qgyw2ieLNE1lG',
                'role' => 'admin'
            ],
            [
                'id' => 3,
                'login' => 'itgears', 
                'email' => 'itgears@gmail.com', 
                'first_name' => 'Steven', 
                'last_name' => 'Calis', 
                'email_verified_at' => '2020-01-15', 
                'password' => '$2y$10$N9EY6uL87FskjDEpd51v4.BSuXHan4dkDhfNsyW0T1PogR6e02dXu',
                'role' => 'manager'
            ],
            [
                'id' => 4,
                'login' => 'itgears', 
                'email' => 'autocruisemsk@gmail.com', 
                'first_name' => 'My Lovely', 
                'last_name' => 'Friend', 
                'email_verified_at' => '2020-01-15', 
                'password' => '$2y$10$N9EY6uL87FskjDEpd51v4.BSuXHan4dkDhfNsyW0T1PogR6e02dXu',
                'role' => 'user'
            ]
		]);
    }
}
