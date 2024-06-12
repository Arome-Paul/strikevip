<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminPanel\AdminController;
use App\Http\Controllers\Auth\DashboardController;
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
    return view('index', [
        'title' => 'Welcome'
    ]);
});



Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('blogpost', [Controller::class, 'blogs'])->name('blogs.post');
Route::get('blogread/{id}/{title}', [Controller::class, 'blogread'])->name('blog.read');

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'bank'])->name('profile.bank');
    Route::post('/structure', [ProfileController::class, 'updateStructure'])->name('update.structure');
    Route::post('/socials', [ProfileController::class, 'updateSocials'])->name('update.socials');
    Route::post('/requestwithdrawal', [ProfileController::class, 'requestwithdrawal'])->name('request.withdraw');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/upload', [ProfileController::class, 'imageUpload'])->name('upload.image');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/withdraw', [ProfileController::class, 'withdraw'])->name('withdraw');
    Route::get('/withdrawsubmitted', [ProfileController::class, 'withdrawsubmitted'])->name('withdraw.submit');
    Route::get('/tasks', [ProfileController::class, 'tasks'])->name('tasks');
    Route::get('/runningtask/{id}', [ProfileController::class, 'runtask'])->name('runtask');
    Route::get('/submittask', [ProfileController::class, 'submittask'])->name('submit.task');
    Route::get('/canceltask', [ProfileController::class, 'canceltask'])->name('cancel.task');
    Route::get('/blogposts', [BlogController::class, 'index'])->name('blog');
    Route::get('/blogpost/{id}/{title}', [BlogController::class, 'read'])->name('read');
    Route::get('/picreset', [ProfileController::class, 'resetProfileImage'])->name('reset.image');
    Route::get('/transaction', [ProfileController::class, 'transaction'])->name('transaction');
    Route::get('/notifications', [ProfileController::class, 'notification'])->name('notification');
    Route::get('/referal', [ProfileController::class, 'referal'])->name('referal');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/adminprofile', [AdminController::class, 'edit'])->name('admin.profile');
    Route::patch('/profileupdate', [AdminController::class, 'update'])->name('update.profile');
    Route::post('newadmin', [AdminController::class, 'store'])->name('new.admin');
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/tasks', [AdminController::class, 'tasks'])->name('admin.tasks');
    Route::get('admin/createtasks', [AdminController::class, 'create_tasks'])->name('admin.create_tasks');
    Route::get('admin/edittask/{id}', [AdminController::class, 'edit_task'])->name('admin.edit_task');
    Route::get('admin/deletetask/{id}', [AdminController::class, 'delete_task'])->name('admin.delete_task');
    Route::get('admin/pendingtasks', [AdminController::class, 'pending_tasks'])->name('admin.pending');
    Route::get('admin/approvetask/{id}', [AdminController::class, 'approve_task'])->name('approve.task');
    Route::get('admin/declinetask/{id}', [AdminController::class, 'decline_task'])->name('decline.task');
    Route::post('admin/createtask', [AdminController::class, 'newtask'])->name('create.task');
    Route::post('admin/updatetask', [AdminController::class, 'updatetask'])->name('update.task');
    Route::get('/blogs', [AdminController::class, 'blogs'])->name('blogs');
    Route::get('/pendingwithdraw', [AdminController::class, 'pendingwithdraw'])->name('pending.withdrawal');
    Route::get('/blog/{id}/{title}', [AdminController::class, 'read'])->name('read');
    Route::get('/createblog', [BlogController::class, 'create'])->name('createblog');
    Route::get('/editpost/{id}/{title}', [BlogController::class, 'editpost'])->name('editpost');
    Route::post('/updateblog', [BlogController::class, 'updateblog'])->name('updateblog');
    Route::put('/createblog', [BlogController::class, 'store'])->name('blogcreate');
    Route::get('/myposts', [BlogController::class, 'mypost'])->name('myposts');
    Route::get('/deletepost/{id}/{title}', [BlogController::class, 'deletepost'])->name('deletepost');
    Route::post ('/search', [AdminController::class, 'search'])->name('search');
    Route::get('admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('admin/admins', [AdminController::class, 'admins'])->name('admin.admins');
    Route::get('admin/addadmin', [AdminController::class, 'addadmin'])->name('add.admin');
    Route::get('admin/approvewithdraw/{id}', [AdminController::class, 'approvewithdraw'])->name('withdrawal.approve');
    Route::get('admin/declinewithdraw/{id}', [AdminController::class, 'declinewithdraw'])->name('withdrawal.decline');
    Route::get('admin/remove/{id}', [AdminController::class, 'removeadmin'])->name('remove.admin');
});