<?php

namespace App\Http\Controllers\API;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\LogResource;
use App\Models\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection|JsonResponse
     */
    public function index(Request $request): ResourceCollection|JsonResponse
    {
        if (!$request->has('filter.user_uuid')) {
            return response()->json(['message' => 'Missing filter[user_uuid], it is required.'], 400);
        }

        $logs = QueryBuilder::for(Log::class)
            ->allowedFilters([
                AllowedFilter::exact('type'),
                AllowedFilter::scope('user_uuid'),
            ]);

        PaginationHelper::Paginate($logs, $request);

        return LogResource::collection($logs);
    }
}
