<?php

namespace App\Livewire\Dynamic;

use App\Models\Post;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithPagination;

class Posts extends Component
{
    use WithPagination;

    public $showCreateForm = false;
    public $showEditForm = false;

    protected $listeners = [
        'postAdded' => 'refreshCreatePost',
        'postUpdated' => 'refreshUpdatedPost',
        'postNotUpdated' => 'refreshNotUpdatedPost',
        'postDeleted' => 'refreshPostDeleted',
        'postNotDeleted' => 'refreshPostNotDeleted',
    ];

    public function render()
    {
        $posts = Post::with(['user', 'category'])
            ->orderBy('id', 'desc')->paginate(10);

        return view('livewire.dynamic.posts', ['posts' => $posts])
            ->extends('layouts.app');
    }

    public function create_post()
    {
        $this->showCreateForm = !$this->showCreateForm;
        $this->showEditForm = false;
    }

    public function show_post($id)
    {

    }

    public function edit_post($id)
    {
        $post = Post::whereId($id)->whereUserId(auth()->id())->first();
        if ($post) {
            $this->showEditForm = !$this->showEditForm;
            $this->showCreateFormForm = false;
            $this->emit('getPost', $post);
        }
    }

    public function delete_post($id)
    {
        $post = Post::whereId($id)->whereUserId(auth()->id())->first();
        if ($post) {
            if (File::exists('/assets/images/' . $post->image)) {
                unlink('/assets/images/' . $post->image);
            }
            $post->delete();
            session()->flash('message', 'Post Deleted successfully.');

            //$this->emit('postDeleted', $post);
        } else {
            $this->emit('postNotDeleted', $post);
        }
    }

    public function refreshCreatePost($post)
    {
        session()->flash('message', 'Post Added successfully');
        $this->showCreateForm = false;
        $this->showEditForm = false;
    }

    public function refreshUpdatedPost()
    {
        session()->flash('message', 'Post update successfully');
        $this->showCreateForm = false;
        $this->showEditForm = false;
    }

    public function refreshNotUpdatedPost()
    {
        session()->flash('message', 'You can not update not yours.');
        $this->showCreateForm = false;
        $this->showEditForm = false;
    }
}
