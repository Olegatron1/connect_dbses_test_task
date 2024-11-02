<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\DatabaseTableTrait;

/**
 * Class DataMigrationService
 *
 * This service handles the migration of data from the source database to the target database.
 */
class DataMigrationService
{
	use DatabaseTableTrait;

	protected string $sourceConnection;
	protected string $targetConnection;

	/**
	 * DataMigrationService constructor.
	 *
	 * @param string $source The source database connection name.
	 * @param string $target The target database connection name.
	 */
	public function __construct(string $source, string $target)
	{
		$this->sourceConnection = $source;
		$this->targetConnection = $target;
	}

	/**
	 * Migrates data from the source database to the target database.
	 *
	 * @return void
	 */
	public function migrateData(): void
	{
		$sourceTables = $this->getTables($this->sourceConnection);

		foreach ($sourceTables as $table) {
			$this->migrateTableData($table);
		}
	}

	/**
	 * Migrates data for a specific table from the source to the target database.
	 *
	 * @param string $table The name of the table to migrate.
	 * @return void
	 */
	protected function migrateTableData(string $table): void
	{
		$data = DB::connection($this->sourceConnection)->table($table)->get();

		foreach ($data as $record) {
			DB::connection($this->targetConnection)->table($table)->updateOrInsert(
				['id' => $record->id],
				(array) $record
			);
		}
	}
}