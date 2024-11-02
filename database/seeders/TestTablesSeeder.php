<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
	public function run(): void
	{
		DB::connection('test_db')->table('test_tables')->upsert([
			['name' => 'Ivan Zub', 'email' => 'tamik@example.com', 'age' => 30],
			['name' => 'Artem Popov', 'email' => 'armik@example.com', 'age' => 25],
		], ['email']);
	}
}
