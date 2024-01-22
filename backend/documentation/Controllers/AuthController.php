<?php

namespace Documentation\Controllers;

use OpenApi\Attributes as OA;

class AuthController
{
    #[OA\Post(
        path: '/api/register',
        summary: 'Register into the system, create new user',
        tags: ['Auth'],
        requestBody:
            new OA\RequestBody(
                required: true,
                description: 'User registration data',
                content:
                    new OA\JsonContent(type: "object", required: ["name", "email", "password", "password_confirmation"], properties: [
                        new OA\Property(property: "name", type: "string", maxLength: 255, example: "John Doe"),
                        new OA\Property(property: "email", type: "string", maxLength: 255, example: "john.doe@gmail.com", format: "email"),
                        new OA\Property(property: "password", type: "string", minLength: 8, maxLength: 255, example: "password123"),
                        new OA\Property(property: "password_confirmation", type: "string", minLength: 8, maxLength: 255, example: "password123"),
                    ])
            ),
        responses: [
            new OA\Response(
                response: '204',
                description: 'User registered successfully'
            ),
            new OA\Response(
                response: '422',
                description: 'Validation error',
            )
        ]
    )]
    public function register() {}

    #[OA\Post(
        path: '/api/login',
        summary: 'Login to the system, start session',
        tags: ['Auth'],
        requestBody:
            new OA\RequestBody(
                required: true,
                description: 'User login data',
                content:
                    new OA\JsonContent(type: "object", required: ["email", "password"], properties: [
                        new OA\Property(property: "email", type: "string", format: "email", maxLength: 255, example: "john.doe@gmail.com"),
                        new OA\Property(property: "password", type: "string", minLength: 8, maxLength: 255, example: "password123"),
                    ])
            ),
        responses: [
            new OA\Response(
                response: '204',
                description: 'User logged in successfully'
            ),
            new OA\Response(
                response: '422',
                description: 'Validation error',
            ),
        ]
    )]
    public function login() {}

    #[OA\Post(
        path: '/api/logout',
        summary: 'Logout from the system, end session',
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: '204',
                description: 'User logged out successfully'
            )
        ]
    )]
    public function logout() {}

    #[OA\Get(
        path: '/api/user',
        summary: 'Get currently logged in user',
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'User data',
                content:
                    new OA\JsonContent(type: "object", properties: [
                        new OA\Property(
                            property: "data",
                            ref: "#/components/schemas/UserResource"
                        ),
                    ])
            )
        ]
    )]
    public function user() {}

    #[OA\Get(
        path: '/sanctum/csrf-cookie',
        summary: 'Get CSRF cookie',
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: '204',
                description: 'Cookie set successfully'
            )
        ]
    )]
    public function cookie() {}
}
