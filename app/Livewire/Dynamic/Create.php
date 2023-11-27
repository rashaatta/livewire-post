<?php

namespace App\Livewire\Dynamic;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $title;
    public $category_id;
    public $body;
    public $image;
    public $image_original;

    public function render()
    {
        $categories = Category::all();
        return view('livewire.dynamic.create',compact('categories'));
    }

    public function save()
    {
        $this->validate([
        'title' => 'required|max:255',
        'category_id' => 'required',
        'body' => 'required',
        'image' => 'nullable|mimes:jpg,jpeg,png,gif|max:2000',
    ]);
        $data['user_id'] = auth()->id();
        $data['title'] = $this->title;
        $data['body'] = $this->body;
        $data['category_id'] = $this->category_id;


        if ($image = $this->image) {
            $filename = Str::slug($this->title) . '.' . $image->getClientOriginalExtension();
            $path = public_path('/assets/images/' . $filename);
            Image::make($image->getRealPath())->save($path, 100);

            $data['image'] = $filename;
        }
        $post = Post::create($data);

        $this->resetInputs();
        $this->emit('postAdded', $post);
    }

    private function resetInputs()
    {
        $this->title = null;
        $this->body = null;
        $this->category_id = null;
        $this->image = null;

    }
}
