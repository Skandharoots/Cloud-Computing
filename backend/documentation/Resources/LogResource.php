<?php

namespace Documentation\Resources;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "LogResource",
    type: "object",
    description: "Log of system entity's actions",
)]
class LogResource
{
    #[OA\Property(property: "uuid", type: "string", format: "uuid", example: "2ba0e460-ba95-4171-8a5a-e0d532835ef6")]
    #[OA\Property(property: "name", type: "string", maxLength: 255)]
    #[OA\Property(property: "type", type: "integer", format: "int32", example: 1, enum: [1, 2, 3, 4, 5, 6, 7, 8, 9],
        description: "1: USER_LOGIN, 2: USER_LOGOUT, 3: USER_REGISTER, 4: USER_UPDATE_PROFILE, 5: USER_AZURE_READ, 6: USER_AZURE_UPLOAD, 7: USER_AZURE_UPDATE, 8: USER_AZURE_DELETE, 9: USER_AZURE_DOWNLOAD")]
    #[OA\Property(property: "description", type: "string", example: "User logged in", nullable: true)]
    #[OA\Property(property: "created_at", type: "string", format: "date-time", example: "2021-05-01T12:00:00+00:00")]
    #[OA\Property(property: "updated_at", type: "string", format: "date-time", example: "2021-05-01T12:00:00+00:00")]
    public function generate() {}
}
