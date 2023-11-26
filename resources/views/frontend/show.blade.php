@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <b>Create new Post</b>
                    <a href="{{route('posts.index')}}" class="btn btn-primary btn-sm float-end">Post</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($post->image !='')
                            <div class="col-md-12 text-center">
                                <img src="{{asset('assets/images/'.$post->image)}}" class="img-fluid"  style="max-width: 100%" title="{{$post->title}}" >
                            </div>
                        @endif
                        <div class="col-md-12 justify-content-center pt-5">
                            <h3>{{$post->title}}</h3>
                            <small>{{$post->category->name}} || By: {{$post->user->name}}</small>
                            <p>{!! $post->body !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
