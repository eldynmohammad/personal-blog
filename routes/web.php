<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\PostController;
use Illuminate\Foundation\Application;
use Illuminate\Routing\RouteGroup;
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

// Route::get('/', function () {
// 	return Inertia::render('Welcome', [
// 		'canLogin' => Route::has('login'),
// 		'canRegister' => Route::has('register'),
// 		'laravelVersion' => Application::VERSION,
// 		'phpVersion' => PHP_VERSION,
// 	]);
// });
Route::group([
		'middleware' => ['auth:sanctum', 'verified'],
		'prefix' => 'admin'
	], function () {
		Route::get('/', function () {
			return Inertia::render('Dashboard');
		})->name('dashboard');
		// Post
		Route::get('/posts', [PostController::class, 'index'])->name('posts');
		Route::get('/create_post', [PostController::class, 'createPostPage'])->name('createPostPage');
		Route::get('/single_post/{id}', [PostController::class, 'singlePost'])->name('singlePost');
		Route::post('/edit_post/{id}', [PostController::class, 'editPost'])->name('editPost');
		Route::post('/post_new', [PostController::class, 'createPost'])->name('createPost');
		Route::post('/delete_post/{id}', [PostController::class, 'deletePost'])->name('deletePost');
		// Category
		Route::get('/categories', [PostController::class, 'getCategories'])->name('categories');
		Route::post('/edit_category/{id}', [PostController::class, 'editCategory'])->name('editCategory');
		Route::post('/create_category', [PostController::class, 'createCategory'])->name('createCategory');
		Route::post('/delete_category/{id}', [PostController::class, 'deleteCategory'])->name('deleteCategory');
		// Tag
		Route::get('/tags', [PostController::class, 'getTags'])->name('tags');
		Route::post('/create_tag', [PostController::class, 'createTag'])->name('createTag');
		Route::post('/edit_tag/{id}', [PostController::class, 'editTag'])->name('editTag');
		Route::post('/delete_tag/{id}', [PostController::class, 'deleteTag'])->name('deleteTag');
});



Route::get('/', [BlogController::class, 'index'])->name('blog_posts');
Route::get('/get_posts', [BlogController::class, 'getPosts']);
Route::get('/get_categories', [BlogController::class, 'getCategories']);
Route::get('/get_tags', [BlogController::class, 'getTags']);
Route::get('/{slug}', [BlogController::class, 'single_post'])->name('blog_post');
Route::get('/author/{authorId}', [BlogController::class, 'author'])->name('blog_author_posts');
Route::get('/category/{slug}', [BlogController::class, 'category'])->name('blog_category_posts');
Route::get('/tag/{slug}', [BlogController::class, 'tag'])->name('blog_category');

