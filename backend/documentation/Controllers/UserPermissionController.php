<?php

namespace Documentation\Controllers;

use OpenApi\Attributes as OA;

class UserPermissionController
{
    #[OA\Get(
        path: '/api/user-permissions',
        summary: 'Get all user permissions',
        tags: ['UserPermission'],
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/filter_by_user_uuid_param_required"),
            new OA\Parameter(ref: "#/components/parameters/filter_by_type_param"),
            new OA\Parameter(ref: "#/components/parameters/page"),
            new OA\Parameter(ref: "#/components/parameters/per_page"),
            new OA\Parameter(ref: "#/components/parameters/paginate"),
        ],
        responses: [
            new OA\Response(
                response: '200_____1',
                description: 'Success response, returns paginated user permissions, per page 15',
                content: [
                    new OA\JsonContent(type: "object", properties: [
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(ref: "#/components/schemas/UserPermissionResource")
                        ),
                        new OA\Property(property: "links", ref: "#/components/schemas/LinksResponsePart"),
                        new OA\Property(property: "meta", ref: "#/components/schemas/MetaResponsePart"),
                    ])
                ],
            ),
            new OA\Response(
                response: '200_____2',
                description: 'Success response, returns not paginated user permissions',
                content: [
                    new OA\JsonContent(type: "object", properties: [
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(ref: "#/components/schemas/UserPermissionResource")
                        ),
                    ])
                ],
            ),
            new OA\Response(
                response: '400',
                description: 'Missing filter[user_uuid], it is required.',
            ),
            new OA\Response(
                response: '404',
                description: 'User not found',
            ),
        ]
    )]
    public function index() {}

    #[OA\Post(
        path: '/api/user-permissions/grant',
        summary: 'Grant a permission to a user',
        tags: ['UserPermission'],
        requestBody:
            new OA\RequestBody(
                required: true,
                description: 'User permission grant data',
                content:
                    new OA\JsonContent(type: "object", required: ["user_uuid", "type"], properties: [
                        new OA\Property(property: "user_uuid", type: "string", format: "uuid", example: "2ba0e460-ba95-4171-8a5a-e0d532835ef6"),
                        new OA\Property(property: "type", type: "integer", format: "int32", example: 1, enum: [1, 2, 3, 4, 5], description: "1 - AZURE_READ, 2 - AZURE_UPDATE, 3 - AZURE_UPLOAD, 4 - AZURE_DELETE, 5 - AZURE_DOWNLOAD"),
                    ])
            ),
        responses: [
            new OA\Response(
                response: '200',
                description: 'User permission granted successfully',
            ),
            new OA\Response(
                response: '404',
                description: 'User not found',
            ),
            new OA\Response(
                response: '422',
                description: 'Validation error',
            ),
        ]
    )]
    public function grant() {}

    #[OA\Delete(
        path: '/api/user-permissions/forbid',
        summary: 'Forbid a permission from a user',
        tags: ['UserPermission'],
        requestBody:
            new OA\RequestBody(
                required: true,
                description: 'User permission forbid data',
                content:
                    new OA\JsonContent(type: "object", required: ["user_uuid", "type"], properties: [
                        new OA\Property(property: "user_uuid", type: "string", format: "uuid", example: "2ba0e460-ba95-4171-8a5a-e0d532835ef6"),
                        new OA\Property(property: "type", type: "integer", format: "int32", example: 1, enum: [1, 2, 3, 4, 5], description: "1 - AZURE_READ, 2 - AZURE_UPDATE, 3 - AZURE_UPLOAD, 4 - AZURE_DELETE, 5 - AZURE_DOWNLOAD"),
                    ])
            ),
        responses: [
            new OA\Response(
                response: '200',
                description: 'User permission forbidden successfully',
            ),
            new OA\Response(
                response: '404',
                description: 'User not found',
            ),
            new OA\Response(
                response: '422',
                description: 'Validation error',
            ),
        ]
    )]
    public function forbid() {}
}
