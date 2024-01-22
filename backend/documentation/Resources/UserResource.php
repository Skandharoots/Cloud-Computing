<?php

namespace Documentation\Resources;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "UserResource",
    type: "object",
    description: "User that uses the system",
)]
class UserResource
{
    #[OA\Property(property: "uuid", type: "string", format: "uuid", example: "2ba0e460-ba95-4171-8a5a-e0d532835ef6")]
    #[OA\Property(property: "name", type: "string", maxLength: 255, example: "John Doe")]
    #[OA\Property(property: "email", type: "string", format: "email", maxLength: 255, example: "john.doe@gmail.com")]
    #[OA\Property(property: "created_at", type: "string", format: "date-time", example: "2021-05-01T12:00:00+00:00")]
    #[OA\Property(property: "updated_at", type: "string", format: "date-time", example: "2021-05-01T12:00:00+00:00")]
    public function generate() {}
}
