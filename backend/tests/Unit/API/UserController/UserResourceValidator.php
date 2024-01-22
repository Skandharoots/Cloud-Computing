<?php

namespace Tests\Unit\API\UserController;

use Tests\AssertableJson;

class UserResourceValidator
{
	public static function validate (AssertableJson $json): AssertableJson
    {
        $validatedJson = $json
            ->whereTypeUuid('uuid')
            ->whereType('name', 'string')
            ->whereType('email', 'string')
            ->whereTypeTimestamp('created_at')
            ->whereTypeTimestamp('updated_at');

		return $validatedJson;
	}
}
