<?php

namespace Documentation\Controllers;

use OpenApi\Attributes as OA;

class UserController
{
    #[OA\Get(
        path: '/api/users',
        summary: 'Get all users',
        description: 'This endpoint returns all users, either paginated or not, depending on the query parameters.',
        tags: ['User'],
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/page"),
            new OA\Parameter(ref: "#/components/parameters/per_page"),
            new OA\Parameter(ref: "#/components/parameters/paginate"),
        ],
        responses: [
            new OA\Response(
                response: '200_____1',
                description: 'Success response, returns paginated users, per page 15',
                content: [
                    new OA\JsonContent(type: "object", properties: [
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(ref: "#/components/schemas/UserResource")
                        ),
                        new OA\Property(property: "links", ref: "#/components/schemas/LinksResponsePart"),
                        new OA\Property(property: "meta", ref: "#/components/schemas/MetaResponsePart"),
                    ])
                ],
            ),
            new OA\Response(
                response: '200_____2',
                description: 'Success response, returns not paginated users',
                content: [
                    new OA\JsonContent(type: "object", properties: [
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(ref: "#/components/schemas/UserResource")
                        ),
                    ])
                ],
            ),
        ]
    )]
    public function index() {}

    #[OA\Get(
        path: '/api/users/{uuid}',
        summary: 'Get a single user by UUID',
        description: 'This endpoint returns a single user by UUID.',
        tags: ['User'],
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/uuid_url_param")
        ],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Success response',
                content: [
                    new OA\JsonContent(type: "object", properties: [
                        new OA\Property(
                            property: "data",
                            ref: "#/components/schemas/UserResource"
                        ),
                    ])
                ]
            ),
            new OA\Response(
                response: '404',
                description: 'User not found',
            ),
        ]
    )]
    public function show() {}

    #[OA\Put(
        path: '/api/users/{uuid}',
        summary: 'Update a user by UUID',
        description: 'This endpoint updates a user by UUID.',
        tags: ['User'],
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/uuid_url_param")
        ],
        requestBody:
            new OA\RequestBody(
                required: true,
                description: 'User update data',
                content: [
                    new OA\JsonContent(type: "object", properties: [
                        new OA\Property(property: "name", type: "string", maxLength: 255, example: "John Doe"),
                        new OA\Property(property: "email", type: "string", format: "email", maxLength: 255, example: "john.doe@email.com"),
                        new OA\Property(property: "password", type: "string", minLength: 8, maxLength: 255, example: "password123"),
                        new OA\Property(property: "password_confirmation", type: "string", minLength: 8, maxLength: 255, example: "password123"),
                    ])
                ]
            ),
        responses: [
            new OA\Response(
                response: '200',
                description: 'User updated successfully',
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
    public function update() {}

    #[OA\Delete(
        path: '/api/users/{uuid}',
        summary: 'Delete a user by UUID',
        description: 'This endpoint deletes a user by UUID.',
        tags: ['User'],
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/uuid_url_param")
        ],
        responses: [
            new OA\Response(
                response: '200',
                description: 'User deleted successfully',
            ),
            new OA\Response(
                response: '404',
                description: 'User not found',
            )
        ]
    )]
    public function destroy() {}
}
