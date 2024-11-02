<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DatabaseCorrectionService;

/**
 * Class DatabaseMigrateCommand
 *
 * This command is responsible for migrating data from the test database to the production database.
 */
class DatabaseMigrateCommand extends Command
{
	/**
	 * @var string $signature Defines the console command.
	 */
	protected $signature = 'db:migrate';

	/**
	 * @var string $description Description of the command.
	 */
	protected $description = 'Migrate data from test database to combat database';

	/**
	 * Executes the data migration command.
	 *
	 * @return void
	 */
	public function handle(): void
	{
		$migrator = new DatabaseCorrectionService();
		$migrator->migrateDatabase();
		$this->info('Database migration completed successfully.');
	}
}
