<?php

namespace App\Livewire\Dynamic;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $post_id;
    public $post;
    public $title;
    public $category_id;
    public $body;
    public $image;
    public $image_original;

    protected $listeners = ['getPost' => 'get_post'];

    public function mount()
    {
        $this->post_id = request()->id;
        $this->post = Post::whereId($this->post_id)->whereUserId(auth()->id())->first();
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.dynamic.edit', [
            'categories' => $categories,
            'post' => $this->post
        ]);
    }

    public function get_post($post)
    {
        $this->post = $post;
        $this->title = $this->post['title'];
        $this->body = $this->post['body'];
        $this->category_id = $this->post['category_id'];
        $this->image = $this->post['image'];
        $this->image_original = $this->post['image'];
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
                if (File::exists('/assets/images/' . $this->image)) {
                    unlink('/assets/images/' . $this->image);
                }
                $filename = Str::slug($this->title) . '.' . $image->getClientOriginalExtension();
                $path = public_path('/assets/images/' . $filename);
                Image::make($image->getRealPath())->save($path, 100);

                $data['image'] = $filename;
            }
            $post->update($data);

            $this->resetInputs();
            $this->emit('postUpdated', $post);
        } else {
            $this->emit('postNotUpdated');
        }
    }
}
