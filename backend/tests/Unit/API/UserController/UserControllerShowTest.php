<?php

namespace Tests\Unit\API\UserController;

use Illuminate\Http\Response;
use Tests\AssertableJson;
use Tests\Unit\API\APIUnitTestCase;

class UserControllerShowTest extends APIUnitTestCase
{
    public function test_users_show_returns_correct_data()
    {
        $user = $this->get_random_user();

        $this->get('/api/users/' . $user->uuid)
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(function (AssertableJson $json) {
                $json->has('data', function (AssertableJson $user) {
                    UserResourceValidator::validate($user);
                });
            });
    }

    public function test_users_show_returns_not_found()
    {
        $this->get('/api/users/' . $this->get_random_uuid())
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
