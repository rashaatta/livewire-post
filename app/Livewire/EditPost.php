<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditPost extends Component
{
    use WithFileUploads;

    public $post_id;
    public $post;
    public $title;
    public $category_id;
    public $body;
    public $image;
    public $image_original;

    public function mount()
    {
        $this->post_id = request()->id;
        $this->post = Post::whereId($this->post_id)->whereUserId(auth()->id())->first();
        $this->title = $this->post->title;
        $this->category_id = $this->post->category_id;
        $this->body = $this->post->body;
        $this->image = $this->post->image;
        $this->image_original = $this->post->image;
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.edit-post',
            [
                'categories' => $categories,
                'post' => $this->post
            ])->extends('layouts.app');
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|max:255',
            'category_id' => 'required',
            'body' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif|max:2000',
        ]);
        $post = Post::whereId($this->post_id)->whereUserId(auth()->id())->first();
        if ($post) {
            $data['title'] = $this->title;
            $data['body'] = $this->body;
            $data['category_id'] = $this->category_id;

            if ($image = $this->image) {
                if(File::exists('/assets/images/' . $this->image)){
                    unlink('/assets/images/' . $this->image);
                }
                $filename = Str::slug($this->title) . '.' . $image->getClientOriginalExtension();
                $path = public_path('/assets/images/' . $filename);
                Image::make($image->getRealPath())->save($path, 100);

                $data['image'] = $filename;
            }
            $post->update($data);

            $this->resetInputs();
            session()->flash('message', 'Post created successfully');
            return redirect()->to('livewire/posts');
        }

        session()->flash('message_error', 'you can not update');
        return redirect()->to('livewire/posts');
    }

    public function return_to_posts()
    {
        return redirect()->to('livewire/posts');
    }

    private function resetInputs()
    {
        $this->title = null;
        $this->body = null;
        $this->category_id = null;
        $this->image = null;

    }


}
