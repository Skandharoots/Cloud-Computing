<?php

namespace Tests\Unit\API;

use App\Models\Log;
use App\Models\User;
use App\Models\UserPermission;
use Tests\TestCase;
use Tests\TestResponse;
use Illuminate\Support\Str;

abstract class APIUnitTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Create a test response instance from a base response.
     *
     * @param  $response
     * @return TestResponse
     */
    protected function createTestResponse($response): TestResponse
    {
        return TestResponse::fromBaseResponse($response);
    }

    protected function get_random_uuid(): string
    {
        return Str::uuid();
    }

    protected function get_random_user(): User
    {
        return User::inRandomOrder()->first();
    }

    protected function get_random_log_type(): int
    {
        return fake()->numberBetween(Log::getLogTypeMin(), Log::getLogTypeMax());
    }

    protected function get_random_user_permission_type(): int
    {
        return fake()->numberBetween(UserPermission::getPermissionTypeMin(), UserPermission::getPermissionTypeMax());
    }
}
