<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudyResource;
use App\Services\ProjectService;
use App\Services\StudyService; // استخدم نفس السيرفيس الموجودة لديك
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class StudyController extends Controller
{
    use AuthorizesRequests;
    protected $studyService;
    protected  $projectService;

    public function __construct(StudyService $studyService ,ProjectService $projectService)
    {
        $this->studyService = $studyService;
        $this->projectService=$projectService;
    }

    public function index(int $projectId): JsonResponse
    {

        $project = $this->projectService->getProjectDetails($projectId);
        $this->authorize('view', $project);
        // استدعاء الدالة المسؤولة عن جلب الدراسات من السيرفيس الحالية
        $studies = $this->studyService->getProjectStudy($projectId); // أو الدالة الموجودة لديك

        return response()->json([
            'status' => true,
            'message' => 'تم جلب دراسات المشروع بنجاح',
            'data' => $studies
        ], 200);
    }
}
