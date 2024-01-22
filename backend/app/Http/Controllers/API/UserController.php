<?php

namespace App\Http\Controllers\API;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\UserResource;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $users = QueryBuilder::for(User::class);

        PaginationHelper::Paginate($users, $request);

        return UserResource::collection($users);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return UserResource
     * @return UserResource
     */
    public function show(Request $request, User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return UserResource
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users|max:255',
            'password' => 'nullable|confirmed|min:8',
        ]);

        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;

        if (isset($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        Log::create(['type' => Log::USER_UPDATE_PROFILE, 'user_id' => $user->id]);

        return response()->json(['message' => 'User updated.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(Request $request, User $user): JsonResponse
    {
        $user->logs()->delete();
        $user->userPermissions()->delete();
        $user->delete();

        return response()->json(['message' => 'User deleted.'], 200);
    }
}
