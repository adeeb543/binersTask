<?php
namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HasFiles
{
    /**
     * رفع ملف جديد (إذا أردت توحيد الرفع أيضاً)
     */
    public function uploadFile($file, string $folder = 'uploads'): ?string
    {
        if (!$file) {
            return null;
        }

        // تخزين الملف في القرص المحدد (مثال: public disk)
        return $file->store($folder, 'public');
    }

    /**
     * حذف الملف القديم أو الحالي بأمان من التخزين
     */
    public function deleteFile(?string $filePath, string $disk = 'public'): bool
    {
        if ($filePath && Storage::disk($disk)->exists($filePath)) {
            return Storage::disk($disk)->delete($filePath);
        }

        return false;
    }
}
