<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\VisitController;
use App\Models\Theme;
use App\Models\Visit;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/theme', function () {
    return Inertia::render('Theme/Index');
})->name('theme.index');
Route::get('api/theme', function () {
    $themes = Theme::paginate(20);
    return response()->json([
        "success" => true,
        "data" => [
            "data" => $themes->items(),
            "last_page" => $themes->lastPage(),
        ],
        "message" => ""
    ]);
})->name('theme.paginated');
Route::get('/visits', function () {
    $visits = Visit::paginate(2);
    return Inertia::render('Visits/Index', [
        'visits' => $visits
    ]);
})->name('visits.index');
Route::get('/api/visits', function (Request $request) {
    return Visit::paginate(2);
})->name('visits.load_more');
Route::get('/images', function () {
    return Inertia::render('Image');
});
Route::get('upload-view', function () {
    return view('upload');
});
Route::post('upload', [VisitController::class, 'upload'])
    ->name('upload');

Route::resource('image', ImageController::class)->except(['update']);
Route::post('image/{id}', [ImageController::class, 'update'])->name('image.update');
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $visits = Visit::paginate(2);
    return Inertia::render('Dashboard', compact('visits'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
