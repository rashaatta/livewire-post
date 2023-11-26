<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class ShowPost extends Component
{
    public $post_id;
    public $post;
    public $title;
    public $category_id;
    public $body;
    public $image;

    public function mount()
    {
        $this->post_id = request()->id;
        $this->post = Post::with(['user', 'category'])->whereId($this->post_id)-> first();
        $this->title = $this->post->title;
        $this->category = $this->post->category->name;
        $this->body = $this->post->body;
        $this->image = $this->post->image;
    }

    public function render()
    {
        return view('livewire.show-post', ['post' => $this->post])->extends('layouts.app');
    }
    public function return_to_posts()
    {
        return redirect()->to('livewire/posts');
    }
}
