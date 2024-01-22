<?php

namespace Documentation\Resources;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "UserPermissionResource",
    type: "object",
    description: "Permission that can be granted to a user",
)]
class UserPermissionResource
{
    #[OA\Property(property: "uuid", type: "string", format: "uuid", example: "2ba0e460-ba95-4171-8a5a-e0d532835ef6")]
    #[OA\Property(property: "name", type: "string", maxLength: 255, example: "AZURE_READ")]
    #[OA\Property(property: "type", type: "integer", format: "int32", example: 1, enum: [1, 2, 3, 4, 5], description: "1 - AZURE_READ, 2 - AZURE_UPDATE, 3 - AZURE_UPLOAD, 4 - AZURE_DELETE, 5 - AZURE_DOWNLOAD")]
    #[OA\Property(property: "created_at", type: "string", format: "date-time", example: "2021-05-01T12:00:00+00:00")]
    #[OA\Property(property: "updated_at", type: "string", format: "date-time", example: "2021-05-01T12:00:00+00:00")]
    public function generate() {}
}
