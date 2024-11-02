<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestTablesTable extends Migration
{
	/**
	 * @return void
	 */
	public function up(): void
	{
		Schema::connection('test_db')->create('test_tables', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('email')->unique();
			$table->integer('age')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * @return void
	 */
	public function down(): void
	{
		Schema::connection('test_db')->dropIfExists('test_tables');
	}
}