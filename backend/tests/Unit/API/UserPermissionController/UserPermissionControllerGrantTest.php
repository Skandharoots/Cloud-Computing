<?php

namespace Tests\Unit\API\UserPermissionController;

use App\Models\UserPermission;
use Illuminate\Http\Response;
use Tests\Unit\API\APIUnitTestCase;

class UserPermissionControllerGrantTest extends APIUnitTestCase
{
    public function test_user_permissions_grant_grants_the_permission()
    {
        $user = $this->get_random_user();
        $permission = $this->get_random_user_permission_type();

        $this->post('/api/user-permissions/grant', [
                'user_uuid' => $user->uuid,
                'type' => $permission
            ])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'User permission granted.'
            ]);

        $this->assertDatabaseHas('user_permissions', [
            'user_id' => $user->id,
            'type' => $permission
        ]);
    }

    public function test_user_permission_grant_returns_not_found()
    {
        $permission = $this->get_random_user_permission_type();

        $this->post('/api/user-permissions/grant', [
                'user_uuid' => $this->get_random_uuid(),
                'type' => $permission
            ])
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
