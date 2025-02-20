<?php

use App\Http\Controllers\NewscategoryController;
use App\Http\Controllers\NewscommentController;
use App\Http\Controllers\NewsController;
use App\Models\newscomment;
use Illuminate\Support\Facades\Route;
//category
route::get('news-categories',[NewscategoryController::class,'index'])->middleware('auth:sanctum');
route::post('news-categories/create',[NewscategoryController::class,'create'])->middleware('auth:sanctum');
route::post('news-categores/update/{id}',[NewscategoryController::class,'update'])->middleware('auth:sanctum');
route::get('news-categores/delete/{id}',[NewscategoryController::class,'destroy'])->middleware('auth:sanctum');
//news
route::get('/news',[NewsController::class,'index'])->middleware('auth:sanctum');
route::post('news/create',[NewsController::class,'create'])->middleware('auth:sanctum');
route::post('news/update/{id}',[NewsController::class,'update'])->middleware('auth:sanctum');
route::get('news/delete/{id}',[NewsController::class,'delete'])->middleware('auth:sanctum');
route::get('news/{id}',[NewsController::class,'news'])->middleware('auth:sanctum');
//comments
route::get('news-comments/{id}',[NewscommentController::class,'index'])->middleware('auth:sanctum');
route::post('news-comment/create',[NewscommentController::class,'create'])->middleware('auth:sanctum');
route::post('news-comment/update/{id}',[NewscommentController::class,'update'])->middleware('auth:sanctum');
route::get('news-comment/delete/{id}',[NewscommentController::class,'destroy'])->middleware('auth:sanctum');
?>
