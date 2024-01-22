<?php

namespace App\Http\Controllers\API;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\UserPermissionResource;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return ResourceCollection|JsonResponse
     */
    public function index(Request $request): ResourceCollection|JsonResponse
    {
        if (!$request->has('filter.user_uuid')) {
            return response()->json(['message' => 'Missing filter[user_uuid], it is required.'], 400);
        }

        $userPermissions = QueryBuilder::for(UserPermission::class)
            ->allowedFilters([
                AllowedFilter::exact('type'),
                AllowedFilter::scope('user_uuid'),
            ]);

        PaginationHelper::Paginate($userPermissions, $request);

        return UserPermissionResource::collection($userPermissions);
    }

    /**
     * Grant a user permission.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function grant(Request $request): JsonResponse
    {
        return response()->json(['message' => 'You are not allowed to grant permissions. Ask an administrator.'], 403);

        $request->validate([
            'user_uuid' => 'required|uuid',
            'type' => 'required|integer'
        ]);

        $user = User::where('uuid', $request->user_uuid)->firstOrFail();

        $user->userPermissions()->create([
            'type' => $request->type
        ]);

        return response()->json(['message' => 'User permission granted.'], 200);
    }

    /**
     * Forbid a user permission.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function forbid(Request $request): JsonResponse
    {
        return response()->json(['message' => 'You are not allowed to grant permissions. Ask an administrator.'], 403);

        $request->validate([
            'user_uuid' => 'required|uuid',
            'type' => 'required|integer'
        ]);

        $user = User::where('uuid', $request->user_uuid)->firstOrFail();

        $user->userPermissions()->where('type', $request->type)->delete();

        return response()->json(['message' => 'User permission forbidden.'], 200);
    }
}
