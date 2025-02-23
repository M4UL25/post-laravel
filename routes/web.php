<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('home', ['title' => 'Home Pageeeee']);
});

Route::get('/about', function () {
    return view('about', ['title' => 'About Page', 'name' => 'Maulana']);
});

Route::get('/posts', function () {
    // $post = Post::latest();

    // // dump(request('search'));
    // if (request('search')) {
    //     $post->where('title', 'like', '%' . request('search') . '%');
    // }

    // $post = Post::with(['author', 'category'])->latest()->get();
    // return view('posts', ['title' => 'Blog Page', 'posts' => Post::latest()->get()]);
    return view('posts', ['title' => 'Blog Page', 'posts' => Post::filter(request(['search', 'category', 'author']))->latest()->paginate(6)->withQueryString()]);
});

Route::get('/posts/{post:slug}', function(Post $post) {
    return view('post', ['title' => 'Single Post', 'post' => $post]);
});

Route::get('/author/{user:username}', function(User $user) {
    // $post = $user->posts->load(['category', 'author']);
    return view('posts', ['title' => count($user->posts) . ' Articles by' . $user->name, 'posts' => $user->posts]);
});

Route::get('/category/{category:slug}', function(Category $category) {
    // $post = $category->posts->load(['category', 'author']);
    return view('posts', ['title' =>' Articles in ' . $category->name, 'posts' => $category->posts]);
});

Route::get('contact', function () {
    return view('contact', ['title' => 'Contact', 'email' => 'sandi2501.ss@gmail.com', 'phone' => '082257141766']);
});
