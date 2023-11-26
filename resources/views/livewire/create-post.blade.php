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
                    <form wire:submit.prevent="save" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{auth()->id()}}"/>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" wire:model="title" class="form-control">
                            @error('title')<span class="text-danger">{{$message}}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select name="category_id" class="form-control" wire:model="category_id">
                                <option>Select one</option>
                                @foreach($categories as $category)
                                    <option
                                        value="{{$category->id}}" {{old('category_id') == $category->id?'selected':''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('category_id')<span class="text-danger">{{$message}}</span>@enderror
                        </div>


                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea type="text" name="body" rows="5" wire:model="body"
                                      class="form-control"></textarea>
                            @error('body')<span class="text-danger">{{$message}}</span>@enderror
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" class="custom-file" wire:model="image">
                            @error('image')<span class="text-danger">{{$message}}</span>@enderror
                        </div>


                        <div class="form-group">
                            <input type="submit" value="Submit" class="btn btn-danger float-end">
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
