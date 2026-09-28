<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudyResource;
use App\Services\StudyService; // استخدم نفس السيرفيس الموجودة لديك
use Illuminate\Http\JsonResponse;

class StudyController extends Controller
{
    protected $studyService;

    public function __construct(StudyService $studyService)
    {
        $this->studyService = $studyService;
    }

    public function index(int $projectId): JsonResponse
    {
        // استدعاء الدالة المسؤولة عن جلب الدراسات من السيرفيس الحالية
        $studies = $this->studyService->getProjectStudy($projectId); // أو الدالة الموجودة لديك

        return response()->json([
            'status' => true,
            'message' => 'تم جلب دراسات المشروع بنجاح',
            'data' => $studies
        ], 200);
    }
}
