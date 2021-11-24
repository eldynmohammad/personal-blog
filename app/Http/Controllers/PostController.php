<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index() {
		$posts = Post::with('user:id,name')
				->with('tags:name,slug')
				->with('categories:name,slug')
				->orderBy('published_at', 'desc')
				->paginate(10);

		return Inertia::render('Dashboard/Posts', ['posts' => $posts]);
	}

	public function createPostPage() {
		$categories = Category::orderBy('name', 'asc')->get();
		$tags = Tag::orderBy('name', 'asc')->get();
		return Inertia::render('Dashboard/CreatePost', [
			'categories' => $categories,
			'tags' => $tags
		]);
	}

	public function createPost(Request $request) {
		$request->validate([
			'title' => [ 'required', 'string' ],
			'body' => [ 'required', 'string' ],
			'categorySelected' => [ 'required', 'array', 'min:1' ],
			'tagSelected' => [ 'required', 'array', 'min:1' ]
		]);

		$catId = [];
		$tagId = [];
		foreach ($request->categorySelected as $cat) {
			$aidi = Category::where('name', $cat)->first()->id;
			array_push($catId, $aidi);
		}
		foreach ($request->tagSelected as $tag) {
			$aidi = Tag::where('name', $tag)->first()->id;
			array_push($tagId, $aidi);
		}
		// dd($tagId);
		$slug = Str::slug($request->title);
		$post = Post::create([
			'title' => $request->title,
			'slug' => $slug,
			'body' => $request->body,
			'post_type' => Post::POST,
			'status' => Post::ACTIVE,
			'published_at' => Carbon::now(),
			'user_id' => Auth::user()->id,
		]);
		$post->categories()->attach($catId);
		$post->tags()->attach($tagId);

		return Redirect::route('posts');
	}
	
	public function singlePost($id)
    {
        $post = Post::with('tags:name,slug')
			->with('categories:name,slug')
			->where('id', $id)
			->first();
		$categories = Category::orderBy('name', 'asc')->get();
		$tags = Tag::orderBy('name', 'asc')->get();

		return Inertia::render('Dashboard/EditPost', [
			'singlePost' => $post,
			'categories' => $categories,
			'tags' => $tags
		]);
    }

	public function editPost(Request $request, $id) {
		$request->validate([
			'title' => [ 'required', 'string' ],
			'body' => [ 'required', 'string' ],
			'categorySelected' => [ 'required', 'array', 'min:1' ],
			'tagSelected' => [ 'required', 'array', 'min:1' ]
		]);

		$catId = [];
		$tagId = [];
		foreach ($request->categorySelected as $cat) {
			$aidi = Category::where('name', $cat)->first()->id;
			array_push($catId, $aidi);
		}
		foreach ($request->tagSelected as $tag) {
			$aidi = Tag::where('name', $tag)->first()->id;
			array_push($tagId, $aidi);
		}
		$slug = Str::slug($request->title);
		$post = Post::where('id', $id)->first();

		$post->update([
				'title' => $request->title,
				'slug' => $slug,
				'body' => $request->body,
				'post_type' => Post::POST,
				'status' => Post::ACTIVE,
				'published_at' => Carbon::now(),
				'user_id' => Auth::user()->id,
			]);
			
		$post->categories()->sync($catId);
		$post->tags()->sync($tagId);

		return Redirect::route('posts');
	}

	public function deletePost(Request $request, $id) {
		$this->validate($request, [
			'id' => 'required',
        ]);

		DB::table('category_post')->where('post_id', $id)->delete();
        Post::where('id', $id)->delete();
		return Redirect::route('posts');

	}

	// ---------- Category ----------
	public function getCategories() {
		$categories = Category::orderBy('name', 'asc')->get();
		return Inertia::render('Dashboard/Categories', ['categories' => $categories]);
	}
	
	public function createCategory(Request $request) {
		$slug = Str::slug($request->categoryName);
		$this->validate($request, [
			'categoryName' => 'required',
		]);
		Category::create([
			'name' => $request->categoryName,
			'slug' => $slug,
		]);
		return Redirect::route('categories');
	}
	
	public function editCategory(Request $request, $id) {
		$this->validate($request, [
			'categoryName' => 'required',
            'id' => 'required',
        ]);
		$slug = Str::slug($request->categoryName);

        Category::where('id', $id)->first()->update([
			'name' => $request->categoryName,
            'slug' => $slug,
        ]);
		return Redirect::route('categories');
	}
	
	public function deleteCategory(Request $request, $id) {
		$this->validate($request, [
			'id' => 'required',
        ]);
        Category::where('id', $request->id)->delete();
		return Redirect::route('categories');
	}
	
	// ---------- Tags ----------
	public function getTags() {
		$tags = Tag::orderBy('name', 'asc')->get();
		return Inertia::render('Dashboard/Tags', ['tags' => $tags]);
	}
	
	public function createTag(Request $request) {
		$slug = Str::slug($request->tagName);
		$this->validate($request, [
			'tagName' => 'required',
		]);
		Tag::create([
			'name' => $request->tagName,
			'slug' => $slug,
		]);
		return Redirect::route('tags');
	}
	
	public function editTag(Request $request, $id) {
		$this->validate($request, [
			'tagName' => 'required',
            'id' => 'required',
        ]);
		$slug = Str::slug($request->tagName);
		
        Tag::where('id', $id)->first()->update([
			'name' => $request->tagName,
            'slug' => $slug,
        ]);
		return Redirect::route('tags');
	}
	
	public function deleteTag(Request $request, $id) {
		$this->validate($request, [
			'id' => 'required',
		]);
		Tag::where('id', $id)->delete();
		return Redirect::route('tags');
	}
}
