<?php

namespace App\Http\Controllers\API;

use App\Helpers\FileHelper;
use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\FileResource;
use App\Models\File;
use App\Models\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection|JsonResponse
     */
    public function index(Request $request): ResourceCollection|JsonResponse
    {
        $this->authorize('azureRead', File::class);

        if (!$request->has('filter.user_uuid')) {
            return response()->json(['message' => 'Missing filter[user_uuid], it is required.'], 400);
        }

        $files = QueryBuilder::for(File::class)
            ->allowedFilters([
                AllowedFilter::scope('user_uuid'),
            ]);

        PaginationHelper::Paginate($files, $request);

        Log::create([
            'type' => Log::USER_AZURE_READ,
            'description' => 'User read files.',
            'user_id' => Auth::user()->id,
        ]);

        return FileResource::collection($files);
    }

    /**
     * Display the specified resource.
     *
     * @param File $azureFile
     * @return FileResource
     */
    public function show(File $azureFile): FileResource
    {
        $this->authorize('azureRead', File::class);

        Log::create([
            'type' => Log::USER_AZURE_READ,
            'description' => 'User read files.',
            'user_id' => Auth::user()->id,
        ]);

        return new FileResource($azureFile);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorize('azureUpload', File::class);

        if (!$request->hasFile('file')) {
            return response()->json(['message' => 'Missing file, it is required.'], 400);
        }

        $file = $request->file('file');

        $extension = FileHelper::GetFileExtensionFromFileName($file->getClientOriginalName());
        $size = $file->getSize();

        DB::beginTransaction();

        $fileDB = File::create([
            'user_id' => Auth::user()->id,
            'filename' => $file->getClientOriginalName(),
            'size' => $size,
            'version' => '1.0.0',
        ]);

        Storage::disk('azure')->put($fileDB->uuid . '.' . $extension, $file->get());

        Log::create([
            'type' => Log::USER_AZURE_UPLOAD,
            'description' => 'User uploaded file' . $fileDB->filename . ' of size ' . $fileDB->size . ' bytes.',
            'user_id' => Auth::user()->id,
        ]);

        DB::commit();

        return response()->json(['message' => 'File created.'], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param File $file
     * @return JsonResponse
     */
    public function update(Request $request, File $azureFile): JsonResponse
    {
        $this->authorize('azureUpdate', File::class);

        $request->validate([
            'filename' => 'nullable|string',
        ]);

        $currentVersion = explode('.', $azureFile->version);
        $currentVersion[2] = $currentVersion[2] + 1;

        $azureFile->filename = $request->filename ?? $azureFile->filename;
        $azureFile->version = implode('.', $currentVersion);
        $azureFile->save();

        Log::create([
            'type' => Log::USER_AZURE_UPDATE,
            'description' => 'User updated file' . $azureFile->filename,
            'user_id' => Auth::user()->id,
        ]);

        return response()->json(['message' => 'File updated.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param File $azureFile
     * @return JsonResponse
     */
    public function destroy(File $azureFile): JsonResponse
    {
        $this->authorize('azureDelete', File::class);

        $extension = FileHelper::GetFileExtensionFromFileName($azureFile->filename);

        Storage::disk('azure')->delete($azureFile->uuid . '.' . $extension);

        Log::create([
            'type' => Log::USER_AZURE_DELETE,
            'description' => 'User deleted file' . $azureFile->filename,
            'user_id' => Auth::user()->id,
        ]);

        $azureFile->delete();

        return response()->json(['message' => 'File deleted.'], 200);
    }

    /**
     * Download the specified resource from storage.
     *
     * @param File $azureFile
     * @return StreamedResponse
     */
    public function download(File $azureFile): StreamedResponse
    {
        $this->authorize('azureDownload', File::class);

        $fileFromAzure = Storage::disk('azure')->get($azureFile->uuid . '.' . FileHelper::GetFileExtensionFromFileName($azureFile->filename));

        $headers = [
            'Content-Type' => Storage::disk('azure')->mimeType($azureFile->uuid . '.' . FileHelper::GetFileExtensionFromFileName($azureFile->filename)),
            'Content-Disposition' => 'attachment; filename="' . $azureFile->filename . '"',
        ];

        Log::create([
            'type' => Log::USER_AZURE_DOWNLOAD,
            'description' => 'User downloaded file' . $azureFile->filename,
            'user_id' => Auth::user()->id,
        ]);

        return response()->streamDownload(function () use ($fileFromAzure) {
            echo $fileFromAzure;
        }, $azureFile->filename, [
            'Content-Disposition' => 'attachment; filename="' . $azureFile->filename . '"',
            'Access-Control-Expose-Headers' => 'Content-Disposition'
        ]);
    }
}
