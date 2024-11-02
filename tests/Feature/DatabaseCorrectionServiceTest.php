<?php

namespace Tests\Feature;

use App\Services\DatabaseCorrectionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB; // Импортируем DB
use Tests\TestCase;

class DatabaseCorrectionServiceTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function it_migrates_data_between_databases()
	{
		DB::connection('test_db')->table('test_tables')->insert([
			'name' => 'John Doe',
			'email' => 'john@example.com',
			'age' => 30,
		]);

		$service = new DatabaseCorrectionService();

		$service->migrateDatabase();

		$this->assertDatabaseHas('test_tables', [
			'name' => 'John Doe',
			'email' => 'john@example.com',
			'age' => 30,
		], 'combat_db');
	}
}
