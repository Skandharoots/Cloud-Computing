<?php

namespace Tests\Unit\API\LogController;

use App\Models\Log;
use Tests\AssertableJson;
class LogResourceValidator
{
	public static function validate (AssertableJson $json): AssertableJson
    {
        $validatedJson = $json
            ->whereTypeUuid('uuid')
            ->whereType('name', 'string')
            ->whereTypeEnum('type', Log::getLogTypes())
            ->whereType('description', 'string|null')
            ->whereTypeTimestamp('created_at')
            ->whereTypeTimestamp('updated_at');

		return $validatedJson;
	}
}
