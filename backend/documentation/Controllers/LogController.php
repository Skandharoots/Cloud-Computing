<?php

namespace Documentation\Controllers;

use OpenApi\Attributes as OA;

class LogController
{
    #[OA\Get(
        path: '/api/logs',
        summary: 'Get all logs',
        tags: ['Log'],
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
                description: 'Success response, returns paginated logs, per page 15',
                content: [
                    new OA\JsonContent(type: "object", properties: [
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(ref: "#/components/schemas/LogResource")
                        ),
                        new OA\Property(property: "links", ref: "#/components/schemas/LinksResponsePart"),
                        new OA\Property(property: "meta", ref: "#/components/schemas/MetaResponsePart"),
                    ])
                ],
            ),
            new OA\Response(
                response: '200_____2',
                description: 'Success response, returns not paginated logs',
                content: [
                    new OA\JsonContent(type: "object", properties: [
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(ref: "#/components/schemas/LogResource")
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
}
