<?php

use App\Models\Exam;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RegisController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/forgot', function () {
    return view('auth.reset');
});
Route::get('/signup', [RegisController::class,  'index']);
Route::post('/signup', [RegisController::class,  'store']);
Route::post('/signup', [RegisController::class,  'store']);

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {

    //dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    //permissions
    Route::resource('permissions', PermissionController::class)->only([
        'index'
    ]);

    //roles
    Route::resource('roles', RoleController::class)->except([
        'show'
    ]);

    //users
    Route::resource('users', UserController::class)->except([
        'show'
    ]);

    //images
    Route::resource('images', ImageController::class)->except([
        'show', 'create', 'edit', 'update'
    ]);

    //videos
    Route::resource('videos', VideoController::class)->except([
        'show', 'create', 'edit', 'update'
    ]);

    //audios
    Route::resource('audios', AudioController::class)->except([
        'show', 'create', 'edit', 'update'
    ]);

    //documents
    Route::resource('documents', DocumentController::class)->except([
        'show', 'create', 'edit', 'update'
    ]);

    //subjects
    Route::resource('subjects', SubjectController::class)->except([
        'show', 'create', 'edit', 'update'
    ]);

    //questions
    Route::resource('questions', QuestionController::class)->except([
        'show'
    ]);

    //exams

    Route::resource('exams', ExamController::class);
    Route::get('/exams/result/{score}/{user_id}/{exam_id}', [ExamController::class, 'result'])->name('exams.result');
    Route::get('/exams/scoreboard/{exam}', [ExamController::class, 'scoreboard'])->name('exams.scoreboard');
    Route::get('/exams/start/{id}', [ExamController::class, 'start'])->name('exams.start');
    Route::get('exams/student/{id}', [ExamController::class, 'student'])->name('exams.student');
    Route::put('exams/assign/{id}', [ExamController::class, 'assign'])->name('exams.assign');
    Route::get('/exams/review/{user_id}/{exam_id}', [ExamController::class, 'review'])->name('exams.review');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
