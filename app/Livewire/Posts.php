<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithPagination;

class Posts extends Component
{
    use WithPagination;

    public function render()
    {
        $posts = Post::with(['user', 'category'])
            ->orderBy('id', 'desc')->paginate(15);
        return view('livewire.posts', ['posts' => $posts])
            ->extends('layouts.app');
    }

    public function create_post()
    {
        return redirect()->to('/livewire/posts/create');
    }

    public function edit_post($id)
    {
        $post = Post::whereId($id)->whereUserId(auth()->id())->first();
        if ($post) {
            return redirect()->to('/livewire/posts/' . $id . '/edit');
        }

        session()->flash('message_error', 'You can not update not yours');
        return redirect()->to('livewire/posts');
    }

    public function show_post($id)
    {
        return redirect()->to('/livewire/posts/' . $id  );
    }

    public function delete_post($id)
    {
        $post = Post::whereId($id)->whereUserId(auth()->id())->first();
        if ($post) {
            if (File::exists('/assets/images/' . $post->image)) {
                unlink('/assets/images/' . $post->image);
            }
            $post->delete();
            session()->flash('message', 'Post deleted successfully');
            return redirect()->to('livewire/posts');
        }

        session()->flash('message_error', 'You can not delete not yours');
        return redirect()->to('livewire/posts');
    }
}
