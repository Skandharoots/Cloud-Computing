<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Auth\Access\HandlesAuthorization;

class AzurePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any files in Azure.
     *
     * @param User $user
     * @return bool
     */
    public function azureRead(User $user): bool
    {
        return $user->userPermissions()->where('type', UserPermission::AZURE_READ)->exists();
    }

    /**
     * Determine whether the user can edit files in Azure.
     *
     * @param User $user
     * @return bool
     */
    public function azureUpdate(User $user): bool
    {
        return $user->userPermissions()->where('type', UserPermission::AZURE_UPDATE)->exists();
    }

    /**
     * Determine whether the user can upload files to Azure.
     *
     * @param User $user
     * @return bool
     */
    public function azureUpload(User $user): bool
    {
        return $user->userPermissions()->where('type', UserPermission::AZURE_UPLOAD)->exists();
    }

    /**
     * Determine whether the user can delete files from Azure.
     *
     * @param User $user
     * @return bool
     */
    public function azureDelete(User $user): bool
    {
        return $user->userPermissions()->where('type', UserPermission::AZURE_DELETE)->exists();
    }

    /**
     * Determine whether the user can download files from Azure.
     *
     * @param User $user
     * @return bool
     */
    public function azureDownload(User $user): bool
    {
        return $user->userPermissions()->where('type', UserPermission::AZURE_DOWNLOAD)->exists();
    }
}
