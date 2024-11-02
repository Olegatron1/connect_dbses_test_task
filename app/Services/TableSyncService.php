<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Traits\DatabaseTableTrait;

/**
 * Class TableSyncService
 *
 * This service synchronizes the table structure between the source and target databases.
 */
class TableSyncService
{
	use DatabaseTableTrait;

	protected string $sourceConnection;
	protected string $targetConnection;

	/**
	 * TableSyncService constructor.
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
	 * Synchronizes the tables from the source to the target database.
	 *
	 * @return void
	 */
	public function syncTables(): void
	{
		$sourceTables = $this->getTables($this->sourceConnection);
		$targetTables = $this->getTables($this->targetConnection);

		foreach ($sourceTables as $table) {
			if (!in_array($table, $targetTables)) {
				$this->createTableFromSource($table);
			}
			$this->updateTableStructure($table);
		}
	}

	/**
	 * Creates a table in the target database based on the structure of the source table.
	 *
	 * @param string $table The name of the table to create.
	 * @return void
	 */
	protected function createTableFromSource(string $table): void
	{
		$createTableQuery = DB::connection($this->sourceConnection)->select("SHOW CREATE TABLE `$table`");
		$createTableSql = $createTableQuery[0]->{'Create Table'};
		DB::connection($this->targetConnection)->statement($createTableSql);
	}

	/**
	 * Updates the table structure in the target database to match the source database.
	 *
	 * @param string $table The name of the table to update.
	 * @return void
	 */
	protected function updateTableStructure(string $table): void
	{
		$sourceColumns = DB::connection($this->sourceConnection)->getSchemaBuilder()->getColumnListing($table);
		$targetColumns = DB::connection($this->targetConnection)->getSchemaBuilder()->getColumnListing($table);

		foreach ($sourceColumns as $column) {
			if (!in_array($column, $targetColumns)) {
				$columnType = DB::connection($this->sourceConnection)->getSchemaBuilder()->getColumnType($table, $column);
				Schema::connection($this->targetConnection)->table($table, function ($schema) use ($column, $columnType) {
					$schema->addColumn($columnType, $column);
				});
			}
		}
	}
}