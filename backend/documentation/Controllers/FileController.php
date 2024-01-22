<?php

namespace Documentation\Controllers;

use OpenApi\Attributes as OA;

class FileController
{
    #[OA\Get(
        path: '/api/azure-files',
        summary: 'Get all files stored in azure cloud cold blob storage.',
        description: 'This endpoint is used to get all files stored in azure cloud cold blob storage. It is paginated and can be filtered by user_uuid.
            User can only get files that he uploaded, must be logged in to use this endpoint and have AZURE_READ permission.',
        tags: ['Azure'],
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/filter_by_user_uuid_param_required"),
            new OA\Parameter(ref: "#/components/parameters/page"),
            new OA\Parameter(ref: "#/components/parameters/per_page"),
            new OA\Parameter(ref: "#/components/parameters/paginate"),
        ],
        responses: [
            new OA\Response(
                response: '200_____1',
                description: 'Success response, returns paginated files, per page 15',
                content: [
                    new OA\JsonContent(type: "object", properties: [
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(ref: "#/components/schemas/FileResource")
                        ),
                        new OA\Property(property: "links", ref: "#/components/schemas/LinksResponsePart"),
                        new OA\Property(property: "meta", ref: "#/components/schemas/MetaResponsePart"),
                    ])
                ],
            ),
            new OA\Response(
                response: '200_____2',
                description: 'Success response, returns not paginated files',
                content: [
                    new OA\JsonContent(type: "object", properties: [
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(ref: "#/components/schemas/FileResource")
                        ),
                    ])
                ],
            ),
            new OA\Response(
                response: '400',
                description: 'Missing filter[user_uuid], it is required.',
            ),
            new OA\Response(
                response: '401',
                description: 'Unauthenticated',
            ),
            new OA\Response(
                response: '403',
                description: 'This action is unauthorized.',
            ),
            new OA\Response(
                response: '404',
                description: 'User not found',
            ),
        ]
    )]
    public function index() {}

    #[OA\Get(
        path: '/api/azure-files/{uuid}',
        summary: 'Get file stored in azure cloud cold blob storage.',
        description: 'This endpoint is used to get file stored in azure cloud cold blob storage. User can only get file that he uploaded, must be logged in to use this endpoint and have AZURE_READ permission.',
        tags: ['Azure'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Success response, returns file',
                content: [
                    new OA\JsonContent(type: "object", properties: [
                        new OA\Property(property: "data", ref: "#/components/schemas/FileResource"),
                    ])
                ],
            ),
            new OA\Response(
                response: '401',
                description: 'Unauthenticated',
            ),
            new OA\Response(
                response: '403',
                description: 'This action is unauthorized.',
            ),
            new OA\Response(
                response: '404',
                description: 'File not found',
            ),
        ]
    )]
    public function show() {}

    #[OA\Post(
        path: '/api/azure-files',
        summary: 'Upload file to azure cloud cold blob storage.',
        description: 'This endpoint is used to upload file to azure cloud cold blob storage. User must be logged in to use this endpoint and have AZURE_UPLOAD permission.',
        tags: ['Azure'],
        requestBody: new OA\RequestBody(
            description: 'File to upload',
            required: true,
            content: [
                new OA\MediaType(
                    mediaType: "multipart/form-data",
                    schema: new OA\Schema(
                        type: "object",
                        required: ["file"],
                        properties: [
                            new OA\Property(property: "file", type: "string", format: "binary", description: "File to upload"),
                        ]
                    )
                )
            ],
        ),
        responses: [
            new OA\Response(
                response: '200',
                description: 'Success response, returns file',
                content: [
                    new OA\JsonContent(type: "object", properties: [
                        new OA\Property(property: "data", ref: "#/components/schemas/FileResource"),
                    ])
                ],
            ),
            new OA\Response(
                response: '400',
                description: 'Missing file, it is required.',
            ),
            new OA\Response(
                response: '401',
                description: 'Unauthenticated',
            ),
            new OA\Response(
                response: '403',
                description: 'This action is unauthorized.',
            ),
            new OA\Response(
                response: '404',
                description: 'File not found',
            ),
        ]
    )]
    public function store() {}

    #[OA\Put(
        path: '/api/azure-files/{uuid}',
        summary: 'Update file stored in azure cloud cold blob storage.',
        description: 'This endpoint is used to update file stored in azure cloud cold blob storage. User can only update file that he uploaded, must be logged in to use this endpoint and have AZURE_UPDATE permission.',
        tags: ['Azure'],
        requestBody:
            new OA\RequestBody(
                required: true,
                description: 'User update data',
                content: [
                    new OA\JsonContent(type: "object", required: ["name", "email"], properties: [
                        new OA\Property(property: "filename", type: "string", maxLength: 255, example: "java_is_terrible.jpg", description: "File name with extension"),
                        new OA\Property(property: "version", type: "integer", format: "int32", example: 1),
                    ])
                ]
            ),
        responses: [
            new OA\Response(
                response: '200',
                description: 'File updated.',
            ),
            new OA\Response(
                response: '401',
                description: 'Unauthenticated',
            ),
            new OA\Response(
                response: '403',
                description: 'This action is unauthorized.',
            ),
            new OA\Response(
                response: '404',
                description: 'File not found',
            ),
            new OA\Response(
                response: '422',
                description: 'Validation error',
            ),
        ]
    )]
    public function update() {}

    #[OA\Delete(
        path: '/api/azure-files/{uuid}',
        summary: 'Delete file stored in azure cloud cold blob storage.',
        description: 'This endpoint is used to delete file stored in azure cloud cold blob storage.
            User can only delete file that he uploaded, must be logged in to use this endpoint and have AZURE_DELETE permission.
            This action is irreversible!',
        tags: ['Azure'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'File deleted.',
            ),
            new OA\Response(
                response: '401',
                description: 'Unauthenticated',
            ),
            new OA\Response(
                response: '403',
                description: 'This action is unauthorized.',
            ),
            new OA\Response(
                response: '404',
                description: 'File not found',
            ),
        ]
    )]
    public function destroy() {}

    #[OA\Get(
        path: '/api/azure-files/{uuid}/download',
        summary: 'Download file stored in azure cloud cold blob storage.',
        description: 'This endpoint is used to download file stored in azure cloud cold blob storage.
            User can only download file that he uploaded, must be logged in to use this endpoint and have AZURE_DOWNLOAD permission.',
        tags: ['Azure'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'File downloaded.',
                content: [
                    new OA\MediaType(
                        mediaType: "application/octet-stream",
                        schema: new OA\Schema(
                            type: "string",
                            format: "binary",
                            example: "bXkgbmV3IGZpbGUgY29udGVudHM= ..."
                        )
                    )
                ],
            ),
            new OA\Response(
                response: '401',
                description: 'Unauthenticated',
            ),
            new OA\Response(
                response: '403',
                description: 'This action is unauthorized.',
            ),
            new OA\Response(
                response: '404',
                description: 'File not found',
            ),
        ]
    )]
    public function download() {}
}
