<?php


use App\Http\Controllers\ReferenceController;

use Illuminate\Support\Facades\Route;

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
    return view('index');
});

// Route::get('/objekt-table',[ObjektController::class,'index'])->name('objekt-table');
// Route::get('students', [StudentController::class, 'index']);
// Route::get('/students/list', [StudentController::class, 'getStudents'])->name('students.list');

Route::get('references/list-data',[ReferenceController::class,'indexData'])->name('references.index.data');
Route::resource('references', ReferenceController::class);
