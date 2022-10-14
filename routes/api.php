<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/get-articles', [ArticleController::class, 'getArticles'])->name('articles.get');
Route::get('/get-article/{id}', [ArticleController::class, 'getArticle'])->name('article.get');
