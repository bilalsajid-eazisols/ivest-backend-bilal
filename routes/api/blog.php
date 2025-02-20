<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogcategoryController;
use App\Http\Controllers\BlogcommentController;
use App\Http\Controllers\BlogController;

//Blog Categories
route::get('blog-categories',[BlogcategoryController::class,'index'])->middleware('auth:sanctum');
route::post('blog-categories/create',[BlogcategoryController::class,'create'])->middleware('auth:sanctum');
route::post('blog-categories/update/{id}',[BlogcategoryController::class,'update'])->middleware('auth:sanctum');
route::get('blog-categories/delete/{id}',[BlogcategoryController::class,'destroy'])->middleware('auth:sanctum');

//Blogs
route::get('/blogs',[BlogController::class,'bloglist']);
route::post('/blogs/create',[BlogController::class,'create'])->middleware('auth:sanctum');
route::post('blogs/update/{id}',[BlogController::class,'update'])->middleware('auth:sanctum');
route::get('blogs/delete/{id}',[BlogController::class,'destroy'])->middleware('auth:sanctum');
route::get('blog/{id}', [BlogController::class,'blog'])->middleware('auth:sanctum');


route::get('blog-comment/{id}',[BlogcommentController::class,'index'])->middleware('auth:sanctum');
route::post('blog-comment/create',[BlogcommentController::class,'create'])->middleware('auth:sanctum');
route::post('blog-comment/update/id',[BlogcommentController::class,'update'])->middleware('auth:sanctum');
route::get('blog-comment/delete/{id}',[BlogcommentController::class,'delete'])->middleware('auth:sanctum');
