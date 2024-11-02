<?php

namespace App\Services;

/**
 * Class DatabaseCorrectionService
 *
 * Provides synchronization of tables and data migration between the test and production databases.
 */
class DatabaseCorrectionService
{
	/**
	 * @var TableSyncService $tableSyncService Service for synchronizing tables.
	 */
	protected TableSyncService $tableSyncService;

	/**
	 * @var DataMigrationService $dataMigrationService Service for data migration.
	 */
	protected DataMigrationService $dataMigrationService;

	/**
	 * DatabaseCorrectionService constructor.
	 *
	 * Initializes the services for table synchronization and data migration.
	 */
	public function __construct()
	{
		$this->tableSyncService = new TableSyncService('test_db', 'combat_db');
		$this->dataMigrationService = new DataMigrationService('test_db', 'combat_db');
	}

	/**
	 * Performs table synchronization and data migration.
	 *
	 * @return void
	 */
	public function migrateDatabase(): void
	{
		$this->tableSyncService->syncTables();
		$this->dataMigrationService->migrateData();
	}
}