<?php

namespace App\Http\Resources\API;

use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $extension = FileHelper::GetFileExtensionFromFileName($this->filename);

        return  [
            'uuid' => $this->uuid,
            'filename' => $this->filename,
            'extension' => $extension,
            'public_url' => env('AZURE_STORAGE_PUBLIC_URL') . $this->uuid . '.' . $extension,
            'size' => $this->size,
            'version' => $this->version,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
