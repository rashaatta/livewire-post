<div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <b>Create new Post</b>
                    <a href="javascript:void(0);" wire:click="return_to_posts "
                       class="btn btn-primary btn-sm float-end">Posts</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($this->image !='')
                            <div class="col-md-12 text-center">
                                <img src="{{asset('assets/images/'.$this->image)}}" class="img-fluid"  style="max-width: 100%" title="{{$this->title}}" >
                            </div>
                        @endif
                        <div class="col-md-12 justify-content-center pt-5">
                            <h3>{{$this->title}}</h3>
                            <small>{{$this->category}} || By: {{$this->post->user->name}}</small>
                            <p>{!! $this->body !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
