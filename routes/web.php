<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::get('/notes', [App\Http\Controllers\NoteController::class, 'addNote']);
Route::get('/api/topics', [App\Http\Controllers\NoteController::class, 'index']);
Route::post('/store/notes', [App\Http\Controllers\NoteController::class, 'addNote']);
Route::put('/notes/{note}', [App\Http\Controllers\NoteController::class, 'update']);
Route::delete('/notes/{note}', [App\Http\Controllers\NoteController::class, 'destroy']);
Route::post('/api/store/topics', [App\Http\Controllers\NoteController::class, 'storeTopic']);
Route::delete('/api/topics/{topic}', [App\Http\Controllers\NoteController::class, 'destroyTopic']);

Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home-ehrer', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/login/{token}', [App\Http\Controllers\Auth\LoginController::class, 'autoLogin'])->name('home');
Route::post('/task/save', [App\Http\Controllers\TaskController::class, 'save'])->middleware('auth');
Route::get('/task/get-one-task', [App\Http\Controllers\TaskController::class, 'getOneTask']);
Route::get('/task/get-all-task', [App\Http\Controllers\TaskController::class, 'getAllTask']);
Route::get('/task/get-task8', [App\Http\Controllers\TaskController::class, 'getTask8']);
Route::get('/task/save-task8', [App\Http\Controllers\TaskController::class, 'saveTask8']);
Route::get('/task/save-task8-feed', [App\Http\Controllers\TaskController::class, 'saveTask8Feed']);
Route::get('/task/get-user-data', [App\Http\Controllers\TaskController::class, 'getUserData']);
Route::get('/task/content/{id}', [App\Http\Controllers\TaskController::class, 'getContent']);
Route::post('app/task/save-video', [App\Http\Controllers\TaskController::class, 'saveVideo']);
Route::post('task/save-image', [App\Http\Controllers\TaskController::class, 'saveImage']);
Route::any('app/task/save-file', [App\Http\Controllers\TaskController::class, 'saveFile']);
//Route::post('app/task/upload-video', [App\Http\Controllers\TaskController::class, 'uploadVideo']);
Route::delete('/task/delete-video/{id}', [App\Http\Controllers\TaskController::class, 'deleteVideo']);
Route::delete('/task/delete-image/{fileName}', [App\Http\Controllers\TaskController::class, 'deleteImage']);
Route::delete('/task/delete-audio/{fileName}', [App\Http\Controllers\TaskController::class, 'deleteAudio']);
Route::post('user/status/save', [App\Http\Controllers\HomeController::class, 'saveStatus']);
Route::post('user/get', [App\Http\Controllers\HomeController::class, 'getUser']);
Route::get('/task/get-auswertung', [App\Http\Controllers\AuswertungController::class, 'getAllTask']);

Route::get('/auswertung', [App\Http\Controllers\HomeController::class, 'auswertung'])->name('auswertung');

Route::get('/task/get-auswertung-ontour', [App\Http\Controllers\AuswertungController::class, 'getAllTaskOntour']);
Route::get('/task/get-classes', [App\Http\Controllers\AuswertungController::class, 'getClasses']);
Route::get('/delete-zip', [App\Http\Controllers\AuswertungController::class, 'deleteZip']);

Route::get('/videos/{filename}', function ($filename)
{
    $path = storage_path('app/public/videos/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});


Route::get('/app/{any}', [App\Http\Controllers\IndexController::class, 'index'])
    ->middleware('auth') // Apply the auth middleware
    ->where('any', '.*');

