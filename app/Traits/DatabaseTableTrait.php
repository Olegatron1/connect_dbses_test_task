<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait DatabaseTableTrait
{
	protected function getTables($connection): array
	{
		return array_map('current', DB::connection($connection)->select('SHOW TABLES'));
	}
}