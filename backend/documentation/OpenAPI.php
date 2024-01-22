<?php

namespace Documentation;

use OpenApi\Attributes as OA;

require(__DIR__ . '/requires.php');

#[OA\Info(title: "Cloud Computing Systems Core API", version: "1.0.2")]
#[OA\Server(url: "https://ccscore.it-core.fun", description: "Development server")]
#[OA\Contact(email: "242213@edu.p.lodz.pl")]
#[OA\OpenApi(openapi: "3.0.0")]
class OpenApi {}

// Run using ./vendor/zircote/swagger-php/bin/openapi documentation -o documentation/docs.yaml --bootstrap documentation/OpenAPI.php

#[OA\Schema(
    title: "LinksResponsePart",
    type: "object",
    description: "Part of successfully paginated response containing links to other pages"
)]
class LinksResponsePart
{
    #[OA\Property(property: "first", type: "string", example: "http://localhost:8000/api/users?page=1")]
    #[OA\Property(property: "last", type: "string", example: "http://localhost:8000/api/users?page=1")]
    #[OA\Property(property: "prev", type: "string", example: "http://localhost:8000/api/users?page=1")]
    #[OA\Property(property: "next", type: "string", example: "http://localhost:8000/api/users?page=1")]
    public function generate() {}
}

#[OA\Schema(
    title: "MetaResponsePart",
    type: "object",
    description: "Part of successfully paginated response containing meta data"
)]
class MetaResponsePart
{
    #[OA\Property(property: "current_page", type: "integer", example: 1)]
    #[OA\Property(property: "from", type: "integer", example: 1)]
    #[OA\Property(property: "last_page", type: "integer", example: 1)]
    #[OA\Property(property: "per_page", type: "integer", example: 15)]
    #[OA\Property(property: "to", type: "integer", example: 15)]
    #[OA\Property(property: "total", type: "integer", example: 15)]
    #[OA\Property(property: "path", type: "string", example: "http://localhost:8000/api/users")]
    #[OA\Property(property: "links", type: "array", items:
        new OA\Items(properties: [
            new OA\Property(property: "url", type: "string", example: "http://localhost:8000/api/users?page=1"),
            new OA\Property(property: "label", type: "string", example: "1"),
            new OA\Property(property: "active", type: "boolean", example: true),
        ])
    )]
    public function generate() {}
}

#[OA\Parameter(
    parameter: "uuid_url_param",
    name: "uuid",
    in: "path",
    required: true,
    schema: new OA\Schema(type: "string", format: "uuid", example: "2ba0e460-ba95-4171-8a5a-e0d532835ef6"),

)]
class UuidPathParam {}

#[OA\Parameter(
    parameter: "filter_by_user_uuid_param",
    name: "filter[user_uuid]",
    description: "Allows for filtering resources by uuid of User",
    in: "query",
    required: false,
    schema: new OA\Schema(type: "string", format: "uuid", example: "2ba0e460-ba95-4171-8a5a-e0d532835ef6"),

)]
class FilterByUserUuidQueryParam {}

#[OA\Parameter(
    parameter: "filter_by_user_uuid_param_required",
    name: "filter[user_uuid]",
    description: "Allows for filtering resources by uuid of User, it is required",
    in: "query",
    required: true,
    schema: new OA\Schema(type: "string", format: "uuid", example: "2ba0e460-ba95-4171-8a5a-e0d532835ef6"),

)]
class FilterByUserUuidRequiredQueryParam {}

#[OA\Parameter(
    parameter: "filter_by_type_param",
    name: "filter[type]",
    description: "Allows for filtering resources by their exact type",
    in: "query",
    required: false,
    schema: new OA\Schema(type: "integer", format: "int32", example: 1),

)]
class FilterByTypeQueryParam {}

#[OA\Parameter(
    name: "page",
    in: "query",
    required: false,
    description: "If pagination is enabled, returns certain page of data",
    schema: new OA\Schema(type: "integer", format: "int32", default: 1)
)]
class PageNumberQueryParam {}

#[OA\Parameter(
    name: "per_page",
    in: "query",
    required: false,
    description: "If pagination is enabled, returns certain amount of data per page",
    schema: new OA\Schema(type: "integer", format: "int32", default: 15)
)]
class PerPageQueryParam {}

#[OA\Parameter(
    name: "paginate",
    in: "query",
    required: false,
    description: "If pagination is enabled, returns paginated data",
    schema: new OA\Schema(type: "boolean", default: true)
)]
class DoPaginateQueryParam {}

#[OA\Parameter(
    name: "type",
    in: "query",
    required: false,
    description: "Filter by type",
    schema: new OA\Schema(type: "integer", format: "int32", default: 1)
)]
class TypeQueryParam {}

#[OA\Parameter(
    name: "user_uuid",
    in: "path",
    required: true,
    description: "Filter the data by user UUID",
    schema: new OA\Schema(type: "string", format: "uuid")
)]
class UserUUIDScope {}
