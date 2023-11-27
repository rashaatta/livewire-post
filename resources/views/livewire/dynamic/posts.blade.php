<div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible" id="alert-session">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{session('message')}}
                </div>
            @endif
            @if(session()->has('message_error'))
                <div class="alert alert-error alert-dismissible" id="alert-session">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{session('message_error')}}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <b>Posts</b>
                    <a href="javascript:void(0);" wire:click="create_post" class="btn btn-primary btn-sm float-end">Create Post</a>
                </div>
                <div class="card-body">

                    @if($showCreateForm)
                        <livewire:dynamic.create/>
                    @endif
                    @if($showEditForm)
                        <livewire:dynamic.edit/>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Owner</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td>
                                        @if($post->image !='')
                                            <img src="{{asset('assets/images/'.$post->image)}}" alt="{{$post->title}}"
                                                 width="100">
                                        @endif
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);"
                                           wire:click="show_post({{$post->id}})">{{$post->title}}</a></td>
                                    <td>{{$post->user->name}}</td>
                                    <td>{{$post->category->name}}</td>
                                    <td>
                                        <a href="javascript:void(0);" wire:click="edit_post({{$post->id}})"
                                           class="btn btn-sm btn-primary">Edit</a>
                                        <a href="javascript:void(0);" wire:click="delete_post({{$post->id}})"
                                           class="btn btn-sm btn-danger"
                                           onclick="if(confirm('Are you sure')); return false;">Delete</a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    {!! $posts->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    setTimeout(function(){
        document.getElementById('alert-session').style.display='none';
    },5000)
</script>
@endpush

