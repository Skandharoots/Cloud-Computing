<?php

namespace Tests\Unit\API\UserPermissionController;

use App\Models\UserPermission;
use Illuminate\Http\Response;
use Tests\Unit\API\APIUnitTestCase;

class UserPermissionControllerForbidTest extends APIUnitTestCase
{
    public function test_user_permissions_forbid_forbids_the_permission()
    {
        $user = $this->get_random_user();
        $permission = $this->get_random_user_permission_type();

        $user->userPermissions()->create([
            'type' => $permission
        ]);

        $this->delete('/api/user-permissions/forbid', [
                'user_uuid' => $user->uuid,
                'type' => $permission
            ])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'User permission forbidden.'
            ]);

        $this->assertDatabaseMissing('user_permissions', [
            'user_id' => $user->id,
            'type' => $permission
        ]);
    }

    public function test_user_permission_forbid_returns_not_found()
    {
        $permission = $this->get_random_user_permission_type();

        $this->delete('/api/user-permissions/forbid', [
                'user_uuid' => $this->get_random_uuid(),
                'type' => $permission
            ])
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
