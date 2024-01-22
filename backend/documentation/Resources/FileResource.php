<?php

namespace Documentation\Resources;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "FileResource",
    type: "object",
    description: "File uploaded to the system",
)]
class FileResource
{
    #[OA\Property(property: "uuid", type: "string", format: "uuid", example: "2ba0e460-ba95-4171-8a5a-e0d532835ef6")]
    #[OA\Property(property: "filename", type: "string", maxLength: 255, example: "java_is_terrible.jpg", description: "File name with extension")]
    #[OA\Property(property: "extension", type: "string", maxLength: 255, example: "jpg", description: "File extension without dot")]
    #[OA\Property(property: "size", type: "integer", format: "int32", example: 1024, description: "File size in bytes")]
    #[OA\Property(property: "version", type: "integer", format: "int32", example: 1)]
    #[OA\Property(property: "public_url", type: "string", maxLength: 255, example: "https://example.com/storage/2ba0e460-ba95-4171-8a5a-e0d532835ef6/java_is_terrible.jpg", description: "Public URL to access the file")]
    #[OA\Property(property: "created_at", type: "string", format: "date-time", example: "2021-05-01T12:00:00+00:00")]
    #[OA\Property(property: "updated_at", type: "string", format: "date-time", example: "2021-05-01T12:00:00+00:00")]
    public function generate() {}
}
