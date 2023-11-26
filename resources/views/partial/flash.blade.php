@if(session('message'))
    <div class="alert alert-{{session('alert-type')}} alert-dismissible" id="alert-session">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{session('message')}}
    </div>
@endif
