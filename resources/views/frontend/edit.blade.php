@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <b>Update Post</b>
                    <a href="{{route('posts.index')}}" class="btn btn-primary btn-sm float-end">Post</a>
                </div>
                <div class="card-body">
                    <form action="{{route('posts.update', $post->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="user_id" value="{{auth()->id()}}"/>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" value="{{old('title', $post->title)}}" class="form-control">
                            @error('title')<span class="text-danger">{{$message}}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select name="category_id" class="form-control">
                                <option>Select one</option>
                                @foreach($categories as $category)
                                    <option
                                        value="{{$category->id}}" {{old('category_id', $post->category_id) == $category->id?'selected':''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('category_id')<span class="text-danger">{{$message}}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea type="text" name="body" rows="5" class="form-control"> {{old('body', $post->body)}} </textarea>
                            @error('body')<span class="text-danger">{{$message}}</span>@enderror
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" class="custom-file">
                            @error('image')<span class="text-danger">{{$message}}</span>@enderror
                        </div>
                        @if($post->image !=='')
                            <div class="form-group">
                                <img src="{{asset('assets/images/'.$post->image)}}" alt="{{$post->title}}" width="100">
                            </div>
                        @endif
                        <div class="form-group">
                            <input  type="submit" value="Submit" class="btn btn-danger float-end">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
