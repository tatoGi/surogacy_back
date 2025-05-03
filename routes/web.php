<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Website\HomePageController;
use App\Http\Controllers\Website\NotificationController;
use App\Http\Controllers\Website\PagesController;
use App\Http\Controllers\Website\RoutesController;
use App\Http\Controllers\Website\SearchController;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;
use App\Http\Controllers\CompanyAuthController;

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

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('/testing', function () {

    $postIds = DB::connection('mysql')->table('wp_term_relationships')->where('term_taxonomy_id', 259)->orderBy('object_id', 'desc')->pluck('object_id');

    $posts = Post::whereIn('id', $postIds)->update(['section_id' => 15]);
});

Route::get('/register', function () {
    return redirect('/login');
});

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Auth::routes();

/*
|--------------------------------------------------------------------------
| Check if user is auth
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    Lfm::routes();
});
Route::middleware(['auth.check'])->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Check if user is SUPERUSER
    |--------------------------------------------------------------------------
    */

    Route::middleware('isSuperuser')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('dashboard');

        // Form Submissions Routes
        Route::get('/admin/form-submissions', [FormSubmissionController::class, 'index'])->name('admin.form-submissions.index');
        Route::get('/admin/form-submissions/{submission}', [FormSubmissionController::class, 'show'])->name('admin.form-submissions.show');
        Route::delete('/admin/form-submissions/{submission}', [FormSubmissionController::class, 'destroy'])->name('admin.form-submissions.destroy');

        // Admin\UploadFilesController
        Route::post('/admin/upload/image', [UploadFilesController::class, 'uploadImage'])->name('image.upload');
        Route::post('/admin/upload/image/delete', [UploadFilesController::class, 'deleteImage'])->name('image.del');
        Route::get('/admin/upload/image/delete', [UploadFilesController::class, 'clearChache'])->name('image.clear');
        //Profile ------------------------------------->
        Route::get('/admin/users', [UsersController::class, 'index']);
        Route::get('/admin/users/add', [UsersController::class, 'create']);
        Route::post('/admin/users/add', [UsersController::class, 'store']);
        Route::get('/admin/users/edit/{id}', [UsersController::class, 'edit']);
        Route::get('/admin/users/logs/{id}', [UsersController::class, 'logs']);
        Route::post('/admin/users/edit/{id}', [UsersController::class, 'update']);
        Route::post('/admin/users/destroy/{id}', [UsersController::class, 'destroy']);

        //Sections ------------------------------------->
        Route::get('/admin/sections', [SectionController::class, 'index'])->name('section.list');
        Route::get('/admin/sections/create', [SectionController::class, 'create']);
        Route::post('/admin/sections/create', [SectionController::class, 'store']);
        Route::get('/admin/sections/edit/{id}', [SectionController::class, 'edit']);
        Route::post('/admin/sections/edit/{id}', [SectionController::class, 'update']);
        Route::get('/admin/sections/destroy/{id}', [SectionController::class, 'destroy']);
        Route::post('/admin/sections/arrange', [SectionController::class, 'arrange']);

        //Post ------------------------------------->
        Route::get('/admin/section/{sec}/posts', [PostController::class, 'index'])->name('post.list');
        Route::get('/admin/section/{sec}/posts/create', [PostController::class, 'create'])->name('post.create');
        Route::post('/admin/section/{sec}/posts/create', [PostController::class, 'store'])->name('post.store');
        Route::get('/admin/section/posts/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
        Route::post('/admin/section/posts/{post}/edit', [PostController::class, 'update'])->name('post.update');
        Route::get('/admin/section/posts/{post}/delete', [PostController::class, 'destroy'])->name('post.destroy');
        Route::delete('/admin/section/posts/DeleteFile/{que}', [PostController::class, 'DeleteFile']);
        Route::get('/admin/send-newsletter/{post}', [PostController::class, 'sendNewsletter'])->name('send.newsletter');
        Route::delete('section/posts/delete-image/{id}', [PostController::class, 'deleteImage'])->name('post.delete-image');
        //Settings ---------------------------
        Route::get('/admin/settings/edit', [SettingsController::class, 'edit'])->name('settings.edit');
        Route::post('/admin/settings/edit', [SettingsController::class, 'update'])->name('settings.update');
        Route::post('/admin/settings/upload-file', [SettingsController::class, 'uploadFile'])->name('settings.upload-file');
        Route::post('/admin/settings/delete-file', [SettingsController::class, 'deleteFile'])->name('settings.delete-file');
        //Banners -------------------------------------->
        Route::get('/admin/banners/{type}', [BannerController::class, 'index'])->name('banner.list');
        Route::get('/admin/banners/{type}/create', [BannerController::class, 'create'])->name('banner.create');
        Route::post('/admin/banners/{type}/create', [BannerController::class, 'store'])->name('banner.store');
        Route::get('/admin/banners/{banner}/edit', [BannerController::class, 'edit'])->name('banner.edit');
        Route::post('/admin/banners/{banner}/edit', [BannerController::class, 'update'])->name('banner.update');
        Route::get('/admin/banners/{banner}/delete', [BannerController::class, 'destroy'])->name('banner.destroy');
        //Language ---------------------------
        Route::get('/admin/languages/edit', [LanguageController::class, 'edit'])->name('languages.edit');
        Route::post('/admin/languages/edit', [LanguageController::class, 'update'])->name('languages.update');

        Route::get('/admin/submissions', [SubmissionController::class, 'index']);
        Route::get('/admin/submission/{submission}', [SubmissionController::class, 'show']);
        Route::get('/admin/submission/destroy/{submission}', [SubmissionController::class, 'destroy']);

        Route::get('/admin/subscribes', [SubmissionController::class, 'subscribe']);
        Route::get('/admin/subscribe/destroy/{subscribe}', [SubmissionController::class, 'destroysubscribe']);

        Route::delete('/admin/sections/DeleteCover/{que}', [SectionController::class, 'DeleteCover']);
        // Route::delete('/admin/section/posts/DeleteFile/{que}', [PostController::class, 'DeleteFile']);

        Route::post('/admin/check-slug', [SectionController::class, 'CheckSlug']);
        Route::post('/admin/check-slug-banner', [BannerController::class, 'CheckSlug']);
        Route::delete('/banners/{id}/delete-image', [BannerController::class, 'deleteImage']);

        // Company Routes
        Route::prefix('admin')->group(function () {
            Route::get('/companies', [CompanyController::class, 'index'])->name('admin.companies.index');
            Route::get('/companies/create', [CompanyController::class, 'create'])->name('admin.companies.create');
            Route::post('/companies', [CompanyController::class, 'store'])->name('admin.companies.store');
            Route::get('/companies/{company}/edit', [CompanyController::class, 'edit'])->name('admin.companies.edit');
            Route::post('/companies/{company}', [CompanyController::class, 'update'])->name('admin.companies.update');
            Route::delete('/companies/{company}', [CompanyController::class, 'destroy'])->name('admin.companies.destroy');
        });

        // Surrogate People Routes
        Route::prefix('admin')->group(function () {
            Route::get('/surrogations', [SurrogatePeopleController::class, 'index'])->name('admin.surrogations.index');
            Route::get('/surrogations/create', [SurrogatePeopleController::class, 'create'])->name('admin.surrogations.create');
            Route::post('/surrogations', [SurrogatePeopleController::class, 'store'])->name('admin.surrogations.store');
            Route::get('/surrogations/{surrogatePeople}/edit', [SurrogatePeopleController::class, 'edit'])->name('admin.surrogations.edit');
            Route::put('/surrogations/{surrogatePeople}', [SurrogatePeopleController::class, 'update'])->name('admin.surrogations.update');
            Route::delete('/surrogations/{surrogatePeople}', [SurrogatePeopleController::class, 'destroy'])->name('admin.surrogations.destroy');
            Route::patch('/surrogations/{surrogatePeople}/toggle-status', [SurrogatePeopleController::class, 'toggleStatus'])->name('admin.surrogate-people.toggle-status');
        });

        // Favorites Routes
        Route::get('/admin/favorites', [FavoriteController::class, 'index'])->name('admin.favorites.index');
        Route::get('/admin/favorites/{company}', [FavoriteController::class, 'show'])->name('admin.favorites.show');
    });
});
Route::get('/company/login', [CompanyAuthController::class, 'showLoginForm'])->name('company.login');
Route::post('/company/login', [CompanyAuthController::class, 'login']);
Route::post('/company/logout', [CompanyAuthController::class, 'logout'])->name('company.logout');

// Protected Company Routes
Route::middleware(['company'])->group(function () {
    Route::get('/company/profile', [CompanyAuthController::class, 'profile'])->name('company.profile');
    Route::post('/surrogate-people/{id}/toggle-favorite', [PagesController::class, 'toggleFavorite'])->name('surrogate.toggle-favorite');
});
Route::post('/submission', [NotificationController::class, 'submission'])->name('submission');
Route::post('/subscribe', [NotificationController::class, 'subscribe'])->name('subscribe');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::any('/', [HomePageController::class, 'homePage']);
Route::get('/contact{model}', [PagesController::class, 'contact'])->name('contact');

// Form Submission Routes
Route::post('/submit-surrogate-form', [PagesController::class, 'submitSurrogateForm'])->name('submit.surrogate.form');
Route::post('/submit-parent-form', [PagesController::class, 'submitParentForm'])->name('submit.parent.form');

Route::any('/{all}', [RoutesController::class, 'index'])->where('all', '.*');




