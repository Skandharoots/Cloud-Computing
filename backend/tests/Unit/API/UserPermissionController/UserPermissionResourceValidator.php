<?php

namespace Tests\Unit\API\UserPermissionController;

use App\Models\UserPermission;
use Tests\AssertableJson;

class UserPermissionResourceValidator
{
	public static function validate (AssertableJson $json): AssertableJson
    {
        $validatedJson = $json
            ->whereTypeUuid('uuid')
            ->whereType('name', 'string')
            ->whereTypeEnum('type', UserPermission::getPermissionTypes())
            ->whereTypeTimestamp('created_at')
            ->whereTypeTimestamp('updated_at');

		return $validatedJson;
	}
}
