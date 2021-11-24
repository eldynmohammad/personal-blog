<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;

class BlogController extends Controller
{
	public function __construct()
	{
		Inertia::setRootView('blog');
	}

	public function index()
	{
		$posts = Post::activePost()
				->with('user:id,name')
				->with('tags:name,slug')
				->with('categories:name,slug')
				->orderBy('id', 'desc')
				->get();

		return Inertia::render('Blog/Index', ['posts' => $posts]);
	}

	public function getPosts() {
		return Post::orderBy('id', 'desc')->get();
	}

	public function getCategories() {
		return Category::orderBy('id', 'asc')->get();
	}

	public function getTags() {
		return Tag::orderBy('id', 'asc')->get();
	}

	public function single_post($slug) {
		$post = Post::activePost()
				->with('user:id,name')
				->with('categories:name,slug')
				->with('tags:name,slug')
				->where('slug', $slug)
				->firstOrFail();
				
		return Inertia::render('Blog/SinglePost', [
			'post' => $post,
			'nextPost' => $post->next_post,
			'prevPost' => $post->prev_post,
		]);
	}

	public function author($authorId) {
		$posts = Post::activePost()
				->with('user:id,name')
				->with('categories:name,slug')
				->where('user_id', $authorId)
				->get();

		return Inertia::render('Blog/Index', ['posts' => $posts]);
	}

	public function category($slug) {
		$posts = Post::activePost()
				->whereHas('categories', function (Builder $query) use($slug) {
					$query->where('slug', $slug);
				})
				->with('user:id,name')
				->with('categories:name,slug')
				->get();

		return Inertia::render('Blog/Index', ['posts' => $posts]);
	}
	
	public function tag($slug) {
		$posts = Post::activePost()
				->whereHas('tags', function (Builder $query) use($slug) {
					$query->where('slug', $slug);
				})
				->with('user:id,name')
				->with('tags:name,slug')
				->with('categories:name,slug')
				->get();

		// return $posts;
		return Inertia::render('Blog/Index', ['posts' => $posts]);
	}
}
