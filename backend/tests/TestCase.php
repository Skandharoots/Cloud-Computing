<?php

namespace Tests;

use Database\Seeders\LogSeeder;
use Database\Seeders\UserPermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

	public function setUp() : void
    {
		parent::setUp();

		$multiplier = 1;

		Log::info('Refreshing database...');

		Artisan::call('migrate:refresh');

		Log::info('Seeding database using multiplier: ' . $multiplier . ' ...');

        (new UserSeeder)->call(new UserSeeder(), false, ['count' => 20 * $multiplier]);
        (new LogSeeder)->call(new LogSeeder(), false, ['count' => 4 * $multiplier]);
        (new UserPermissionSeeder)->call(new UserPermissionSeeder(), false, ['count' => 4 * $multiplier]);
	}

    protected function tearDown():void
    {
        DB::disconnect();
    }
}
