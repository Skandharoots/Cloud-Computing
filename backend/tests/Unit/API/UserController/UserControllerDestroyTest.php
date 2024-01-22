<?php

namespace Tests\Unit\API\UserController;

use Illuminate\Http\Response;
use Tests\Unit\API\APIUnitTestCase;

class UserControllerDestroyTest extends APIUnitTestCase
{
    public function test_users_destroy_returns_not_found()
    {
        $this->delete('/api/users/' . $this->get_random_uuid())
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_users_destroy_deletes_user()
    {
        $user = $this->get_random_user();

        $this->delete('/api/users/' . $user->uuid)
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing('users', [
            'uuid' => $user->uuid
        ]);
    }

    public function test_users_destroy_deletes_user_logs()
    {
        $user = $this->get_random_user();

        $this->delete('/api/users/' . $user->uuid);

        $this->assertDatabaseMissing('logs', [
            'user_id' => $user->id
        ]);
    }
}
