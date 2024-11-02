<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TestTablesMigrationTest extends TestCase
{
	use RefreshDatabase;

	protected function setUp(): void
	{
		parent::setUp();

		Schema::connection('test_db')->dropIfExists('test_tables');

	}

	public function testCreatesTestTables()
	{
		$this->artisan('migrate --database=test_db');

		$this->assertTrue(Schema::connection('test_db')->hasTable('test_tables'));
	}

	public function testDropsTestTables()
	{
		$this->assertFalse(Schema::connection('test_db')->hasTable('test_tables'));
	}
}