<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['user', 'category'])
            ->orderBy('id', 'desc')->paginate(5);
        return view('frontend.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('frontend.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'category_id' => 'required',
            'body' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif|max:2000',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $post = Post::create($request->all());
        if ($image = $request->file('image')) {
            $filename = Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $path = public_path('/assets/images/' . $filename);
            Image::make($image->getRealPath())->save($path, 100);

            $post->image = $filename;
            $post->save();
        }
        return redirect()->route('posts.index')->with([
            'message' => 'Post created successfully',
            'alert-type' => 'success'
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with(['user', 'category'])->whereId($id)->first();
        if ($post) {
            return view('frontend.show', compact('post'));
        }
        return redirect()->route('posts.index')->with([
            'message' => 'You have not permission to continue this process.',
            'alert-type' => 'danger'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::whereId($id)->first();
        if ($post) {
            $categories = Category::all();
            return view('frontend.edit', compact('post', 'categories'));
        }
        return redirect()->route('posts.index')->with([
            'message' => 'You have not permission to continue this process.',
            'alert-type' => 'danger'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'category_id' => 'required',
            'body' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif|max:2000',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $post = Post::whereId($id)->first();
        if ($post) {
            $post->update($request->all());
            if ($image = $request->file('image')) {
                if (File::exists('assets/images/' . $post->image)) {
                    unlink('assets/images/' . $post->image);
                }
                $filename = Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
                $path = public_path('/assets/images/' . $filename);
                Image::make($image->getRealPath())->save($path, 100);

                $post->image = $filename;
                $post->save();
            }
            return redirect()->route('posts.index')->with([
                'message' => 'Post updated successfully',
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('posts.index')->with([
            'message' => 'You have not permission to continue this process.',
            'alert-type' => 'danger'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::whereId($id)->first();
        if ($post) {
            if ($post->image != '') {
                if (File::exists('assets/images/' . $post->image)) {
                    unlink('assets/images/' . $post->image);
                }
            }
            $post->delete();
            return redirect()->route('posts.index')->with([
                'message' => 'Post deleted successfully',
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('posts.index')->with([
            'message' => 'You have not permission to continue this process.',
            'alert-type' => 'danger'
        ]);
    }
}
