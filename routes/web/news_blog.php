<?php
use App\Http\Middleware\admin_auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\BlogcategoryController;
use App\Http\Controllers\NewscategoryController;

Route::get('admin/blogs', [BlogController::class, 'index'])->middleware(admin_auth::class)->name('blogs');
Route::get('admin/blog-categories',  [BlogcategoryController::class, 'index'])->middleware(admin_auth::class)->name('blogscategories');

Route::get('admin/news', [NewsController::class, 'index'])->middleware(admin_auth::class)->name('news');
Route::get('admin/news/create', [NewsController::class, 'new']);
// Route::get('admin/news/categories',  [NewscategoryController::class, 'index'])->middleware(admin_auth::class)->name('newscategories');
// Route::post('admin/news-category/save', [NewscategoryController::class, 'create']);
// Route::post('admin/news-categories/update/{id}', [NewscategoryController::class, 'update']);

Route::post('admin/news/save', [NewsController::class, 'create']);
Route::post('admin/news/update/{id}', [NewsController::class, 'update']);

Route::get('blogs/delete/{id}', [BlogController::class, 'destroy'])->middleware(admin_auth::class);
Route::get('news/delete/{id}', [NewsController::class, 'destroy'])->middleware(admin_auth::class);
Route::get('admin/blogs/create', [BlogController::class, 'new']);
Route::post('admin/blog/save', [BlogController::class, 'create']);
Route::post('admin/blog/update/{id}', [BlogController::class, 'update']);
Route::get('blog/{id}', action: [BlogController::class, 'blog'])->middleware(admin_auth::class);
Route::get('blog-categories/delete/{id}', [BlogcategoryController::class, 'destroy'])->middleware(admin_auth::class);
Route::get('news/{id}', action: [NewsController::class, 'news'])->middleware(admin_auth::class);
Route::post('admin/blog-category/save', [BlogcategoryController::class, 'create'])->middleware(admin_auth::class);
Route::post('admin/blog-categories/update/{id}', [BlogcategoryController::class, 'update'])->middleware(admin_auth::class);
Route::get('admin/categories',  [NewscategoryController::class, 'index'])->middleware(admin_auth::class)->name('newscategories');
Route::post('admin/category/save', [NewscategoryController::class, 'create']);
Route::post('admin/categories/update/{id}', [NewscategoryController::class, 'update']);
Route::get('admin/categories/delete/{id}', [NewscategoryController::class, 'destroy']);
Route::post('admin/blog/url/save',[BlogController::class,'urlsave']);
Route::post('admin/news/url/save',[NewsController::class,'urlsave']);


?>
