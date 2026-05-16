<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TeacherApiController;
use App\Http\Controllers\Api\StudentApiController;
use App\Http\Controllers\Api\SubjectApiController;
use App\Http\Controllers\Api\ClassroomApiController;
use App\Http\Controllers\Api\AcademicYearApiController;
use App\Http\Controllers\Api\ExpertiseApiController;
use App\Http\Controllers\Api\ScheduleExamApiController;
use App\Http\Controllers\Api\ActivityInformationApiController;
use App\Http\Controllers\Api\TeachingAssignmentApiController;

/*
|--------------------------------------------------------------------------
| API Routes – SIAK LMS
|--------------------------------------------------------------------------
|
| Base URL: /api
| Auth: Laravel Sanctum (Bearer Token)
|
| Login dulu via POST /api/login untuk mendapatkan token,
| lalu sertakan header: Authorization: Bearer {token}
|
*/

// ── Public (tanpa auth) ──────────────────────────────────────────────
Route::post('/login', [AuthController::class, 'login']);

// ── Protected (perlu token Sanctum) ──────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Teachers
    Route::get('/teachers/me', [TeacherApiController::class, 'me']);
    Route::get('/teachers', [TeacherApiController::class, 'index']);
    Route::get('/teachers/{id}', [TeacherApiController::class, 'show']);

    // Students
    Route::get('/students/me', [StudentApiController::class, 'me']);
    Route::get('/students', [StudentApiController::class, 'index']);
    Route::get('/students/{id}', [StudentApiController::class, 'show']);

    // Subjects
    Route::get('/subjects', [SubjectApiController::class, 'index']);
    Route::get('/subjects/{id}', [SubjectApiController::class, 'show']);

    // Classrooms
    Route::get('/classrooms', [ClassroomApiController::class, 'index']);
    Route::get('/classrooms/{id}', [ClassroomApiController::class, 'show']);

    // Academic Years
    Route::get('/academic-years', [AcademicYearApiController::class, 'index']);

    // Expertises (Jurusan)
    Route::get('/expertises', [ExpertiseApiController::class, 'index']);

    // Schedule Exams
    Route::get('/schedule-exams', [ScheduleExamApiController::class, 'index']);
    Route::get('/schedule-exams/{id}', [ScheduleExamApiController::class, 'show']);

    // Activity Informations
    Route::get('/activity-informations', [ActivityInformationApiController::class, 'index']);
    Route::get('/activity-informations/{id}', [ActivityInformationApiController::class, 'show']);

    // Teaching Assignments
    Route::get('/teaching-assignments', [TeachingAssignmentApiController::class, 'index']);
});
